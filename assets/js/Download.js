$(document).ready(function () {
  // const BASEURL = "www.suportevt.com/cliente/";
  const BASEURL = "http://localhost/php7.4/Projects-7.4/Site/cliente/";

  $.fn.getFiles = function () {
    var files = [];

    $("input[type=checkbox]:checked").each(function (index, element) {
      if (!$(element).hasClass("all")) {
        files.push(
          $(element)
            .parents(".row")
            .children(".name")
            .children("a")
            .attr("href")
        );
      }
    });

    return files;
  };

  $(".files").on("click", function () {
    var files = $().getFiles();

    function downloadNextFile(index) {
      if (index < files.length) {
        var link = $("<a>", {
          href: files[index],
          download: "",
        })
          .hide()
          .appendTo("body");
        link[0].click();
        link.remove();

        setTimeout(function () {
          downloadNextFile(index + 1);
        }, 1000);
      }
    }

    downloadNextFile(0);
  });

  $(".zipped").on("click", function () {
    const data = $().getFiles();
    const filename = $(".page-name").html().split("-")[0].trim();

    $.ajax({
      type: "post",
      url: BASEURL + "Home/zipFiles",
      data: {
        download: false,
        filename: filename,
      },
      dataType: "html",
      success: function (response) {},
    });

    $.ajax({
      type: "post",
      url: BASEURL + "Home/zipFiles",
      data: {
        download: true,
        files: data,
        filename: filename,
      },
      dataType: "html",
      success: function (response) {
        var link = $("<a>", { href: response, download: "" })
          .hide()
          .appendTo("body");
        link[0].click();
        link.remove();
      },
    });
  });

  if ($(".download-select").length < 2) {
    $(".all").addClass("disable");
  }

  $(".download").on("change", function (e) {
    if ($(this).is(":checked") && $(this).hasClass("disable") == false) {
      $(".download-btn").css("visibility", "visible");
    } else if ($(".download").is(":checked") !== true) {
      $(".download-btn").css("visibility", "hidden");
    }
  });

  $(".all").on("change", function (e) {
    if (!$(this).is(":checked") && $(this).hasClass("disable") == false) {
      $(".download-btn").css("visibility", "hidden");
    }
    $(".download").prop("checked", $(".all").prop("checked"));
  });
});
