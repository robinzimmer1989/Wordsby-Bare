<?php
add_action('wp_ajax_trigger_netlify_build', 'trigger_netlify_build_function');
function trigger_netlify_build_function(){

    $webhook = $_POST['webhook'];
    $reponse = array();

    if(!empty($webhook)){
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $webhook); 
        curl_setopt($ch, CURLOPT_POST, 1);
        // I had to pass in a variable to make the post request work
        curl_setopt($ch, CURLOPT_POSTFIELDS,"var=value");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);      
        
        if($output){
            $response['response'] = $output;
        } else {
            $response['response'] = "Build is triggered";
        }

    }else{
        $response['response'] = "No webhook provided";
    }

    header( "Content-Type: application/json" );
    echo json_encode($response);

    exit();
}
?>