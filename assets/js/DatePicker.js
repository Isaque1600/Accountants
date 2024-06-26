$(document).ready(function () {
  $.datepicker.regional["pt-BR"] = {
    closeText: "Fechar",
    prevText: "&#x3c;Anterior",
    nextText: "Pr&oacute;ximo&#x3e;",
    currentText: "Hoje",
    monthNames: [
      "Janeiro",
      "Fevereiro",
      "Março",
      "Abril",
      "Maio",
      "Junho",
      "Julho",
      "Agosto",
      "Setembro",
      "Outubro",
      "Novembro",
      "Dezembro",
    ],
    monthNamesShort: [
      "Janeiro",
      "Fevereiro",
      "Março",
      "Abril",
      "Maio",
      "Junho",
      "Julho",
      "Agosto",
      "Setembro",
      "Outubro",
      "Novembro",
      "Dezembro",
    ],
    dayNames: [
      "Domingo",
      "Segunda-feira",
      "Terça-feira",
      "Quarta-feira",
      "Quinta-feira",
      "Sexta-feira",
      "Sabado",
    ],
    dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
    dayNamesMin: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
    weekHeader: "Sm",
    dateFormat: "dd/mm/yy",
    firstDay: 0,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: "",
  };
  $.datepicker.setDefaults($.datepicker.regional["pt-BR"]);

  $(".date").datepicker({
    dateFormat: "MM 'de' yy",
    changeMonth: true,
    changeYear: true,
    onClose: function (dateText, inst) {
      $(this).datepicker(
        "setDate",
        new Date(inst.selectedYear, inst.selectedMonth, 1)
      );
      $(".form").trigger("submit");
    },
    defaultDate: "-1m",
  });
  // $(".date").monthpicker({
  //   dateFormat: "MM 'de' yy",
  // });
});
