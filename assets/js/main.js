$(document).ready(function () {
  var tempoInativo = function () {
    var time;
    window.onload = resetTimer;
    // DOM Events
    document.onmousemove = resetTimer;
    document.onmousedown = resetTimer;
    document.onkeydown = resetTimer;

    function logout() {
      location.href = "../zyro/ajax/logout.php";
    }

    function resetTimer() {
      clearTimeout(time);
      time = setTimeout(logout, 1200000);
      // 1000 ms = 1 s | 12000000 = 20min
    }
  };

  function continuaLogado() {
    var xhr = new XMLHttpRequest();
    var url = "../zyro/ajax/checkstatus.php";
    var params = "checkLoginTime=1";

    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Manipular a resposta do servidor
        //console.log(xhr.responseText);
      }
    };

    xhr.send(params);
    setTimeout(function () {
      continuaLogado();
    }, 2000);
  }

  $.fn.customSelect = function () {
    var element = this;

    $(this)
      .find(".option")
      .on("click", function (e) {
        $(element).find(".selected-value").val($(this).html());
        $(element).find(".select-btn").val($(this).html());
        $(".form").trigger("submit");
      });

    $(".custom-select").not(this).removeClass("active");
    $(this).toggleClass("active");
  };

  continuaLogado();
  tempoInativo();

  $(".monthpicker").on("click", function () {
    $(this).customSelect();
  });

  $(".yearpicker").on("click", function () {
    $(this).customSelect();
  });

  $(".namepicker").on("click", function () {
    $(this).customSelect();
  });

  $(document).on("click", function (e) {
    if (
      $(".custom-select:hover").length == 0 &&
      $(".custom-select").hasClass("active")
    ) {
      $(".custom-select").removeClass("active");
    }
  });

  $(".items-page").html($(".items-page").html() + $(".row").length);
});
