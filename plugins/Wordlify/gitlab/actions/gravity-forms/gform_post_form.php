<?php
    
    add_action( 'gform_post_form_trashed', 'commitForms', 10, 1);
    add_action( 'gform_post_form_restored', 'commitForms', 10 );
    add_action( 'gform_post_form_duplicated', 'commitForms', 10, 2 );
    add_action( 'gform_post_form_deactivated', 'commitForms', 10, 1 );
    add_action( 'gform_post_form_activated', 'commitForms', 10, 2 );
    add_action( 'gform_after_save_form', 'commitForms', 10, 2 );
    add_action( 'gform_after_delete_form', 'commitForms' );
    
    function commitForms() {
        $client = getGitlabClient(); if (!$client) return;
        
        global $branch;
        
        // if the media branch exists we're going to commit there
        $media_branch_exists = desiredBranchExists($client);
        
        if ($media_branch_exists) {
            global $mediaBranch;
            $used_branch = $mediaBranch;
        } else {
            // otherwise just commit to the main branch
            $used_branch = $branch;
        }
        
        $forms_objects = GFAPI::get_forms();
        
        // foreach ($forms_objects as &$form) {
        //     $form['formId'] = $form['id'];
        //     unset($form['id']);
        
        //     $form['form_fields'] = $form['fields'];
        //     unset($form['fields']);
        
        //     foreach ($form['form_fields'] as &$field) {
        //         unset($field['id']);
        
        //         $field['form_fields'] = $field['fields'];
        //         unset($field['fields']);
        
        //         if ($field['form_fields'] === "") {
        //             $field['form_fields'] = null;
        //         }
        //     }
        // }
        
        $forms = json_encode(
                             $forms_objects, JSON_UNESCAPED_SLASHES
                             );
        
        $base_path = "wordsby/data/";
        
        $user = getCurrentUser();
        $commit_message =
        "Gravity forms updated by " . $user['name'] . " from " .  get_site_url();
        
        $commit = $client->api('repositories')->createCommit(
                                                             WORDLIFY_GITLAB_PROJECT_ID,
                                                             [
                                                             'branch' => $used_branch,
                                                             'commit_message' => $commit_message,
                                                             'actions' => [
                                                             [
                                                             'action' => updateOrCreate(
                                                                                        $client, $base_path, 'gravity_forms.json'
                                                                                        ),
                                                             'file_path' => $base_path . "gravity_forms.json",
                                                             'content' => $forms,
                                                             'encoding' => 'text'
                                                             ],
                                                             ],
                                                             'author_email' => $user['name'],
                                                             'author_name' => $user['email']
                                                             ]
                                                             );
        
        if ($media_branch_exists) {
            // create merge request now that we've commited our data
            $merge_request = $client->api('merge_requests')->create(
                                                                    WORDLIFY_GITLAB_PROJECT_ID,  // project_id
                                                                    $mediaBranch,               // source_branch
                                                                    $branch,                    // target_branch
                                                                    $commit_message            // title
                                                                    );
            
            // immediately approve merge request
            if (isset($merge_request['iid'])) {
                try {
                    $approved_merge_request = $client->api('merge_requests')->merge(
                                                                                    WORDLIFY_GITLAB_PROJECT_ID,
                                                                                    $merge_request['iid'],
                                                                                    "$commit_message [MERGE MEDIA]"
                                                                                    );
                    
                    // delete media branch
                    $deleted_branch = $client->api('repositories')->deleteBranch(
                                                                                 WORDLIFY_GITLAB_PROJECT_ID,
                                                                                 $mediaBranch
                                                                                 );
                } catch (Exception $e) {
                    write_log($e);
                }
            }
        }
        
        return $commit;
    }
    
    ?>
