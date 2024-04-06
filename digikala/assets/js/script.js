jQuery(document).ready(function ($) {
  $(document).on("click", ".dk_thumbnails img", function () {
    $(".dk_thumbnail img").attr("src", $(this).attr("src"));
  });

  $(window).scroll(load_digikala_product);

  function load_digikala_product() {
    let offset = 300;

    let start_of_view = $(window).scrollTop() - offset;
    let end_of_view = $(window).scrollTop() + $(window).height() + offset;

    $(".dk_preloader:not(.active)").each(function (index) {
      let distance = $(this).offset().top + $(this).outerHeight();

      // console.log("ok");
      if (distance >= start_of_view && distance <= end_of_view) {
        // console.log("ok");
        $(this).addClass("active");
        let _this = $(this);
        $.ajax({
          url: digikala_dk.ajax_url,
          data: {
            action: "dk_get_product",
            id: $(this).data("dk"),
          },
          success: function (result) {
            console.log(result);
            $(_this).replaceWith(result.data.html);
          },
        });
      }
    });
  }
  load_digikala_product();
});
