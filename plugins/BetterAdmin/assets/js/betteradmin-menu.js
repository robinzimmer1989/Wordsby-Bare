jQuery(document).ready(function($) {
  $(".build_webhook").click(function() {
    var webhook = $(".build_webhook").attr("data-value");

    $.ajax({
      type: "POST",
      url: ajaxurl,
      beforeSend: function(xhr) {
        $(".build_webhook").html(
          '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>'
        );
      },
      data: {
        action: "trigger_netlify_build",
        webhook
      }
    }).done(function(msg) {
      $(".build_webhook").html("Trigger build");
      alert(msg.response);
    });
  });
});
