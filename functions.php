<?php 
require_once dirname( __FILE__ ) . "/lib/class-tgm-plugin-activation.php";

require_once dirname( __FILE__ ) . "/functions/require-plugins.php";
require_once dirname( __FILE__ ) . "/functions/write_log.php";
require_once dirname( __FILE__ ) . "/functions/prevent-init-being-called-twice.php";
require_once dirname( __FILE__ ) . "/functions/discourage-search-engines.php";
require_once dirname( __FILE__ ) . "/functions/redirect-index-to-admin.php";
require_once dirname( __FILE__ ) . "/functions/activate-pretty-permalinks.php";
require_once dirname( __FILE__ ) . "/functions/add-theme-support.php";
require_once dirname( __FILE__ ) . "/functions/acf-google-map-key.php";
require_once dirname( __FILE__ ) . "/functions/trigger-build.php";
require_once dirname( __FILE__ ) . "/functions/default-admin-theme.php";

require_once dirname( __FILE__ ) . "/plugins/AdminNotices/admin-notices.php";
require_once dirname( __FILE__ ) . "/plugins/WordsbyCore/wordsby-core.php";
require_once dirname( __FILE__ ) . "/plugins/BetterAdmin/better-admin.php";
require_once dirname( __FILE__ ) . "/plugins/Wordlify/wordlify.php";
?>