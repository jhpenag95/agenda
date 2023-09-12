$(document).ready(function () {
  $("#example").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
    },
    responsive: true,
    rowReorder: {
      selector: "td:nth-child(2)",
    },
    dom:
      '<"row"<"col-sm-6"l><"col-sm-6"f>>' +
      '<"row"<"col-sm-12"B>>' +
      '<"row"<"col-sm-12"t>>' +
      '<"row"<"col-sm-5"i><"col-sm-7"p>>',
    buttons: ["csv", "excel", "pdf", "print"],
  });
});
