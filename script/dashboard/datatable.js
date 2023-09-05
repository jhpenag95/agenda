$(document).ready(function () {
  let table = $("#example").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
    },
    responsive: true,
    rowReorder: {
        selector: 'td:nth-child(2)'
    },
    dom:
      '<"row"<"col-sm-6"l><"col-sm-6"f>>' +
      '<"row"<"col-sm-12"B>>' +
      '<"row"<"col-sm-12"t>>' +
      '<"row"<"col-sm-5"i><"col-sm-7"p>>',
    buttons: ["csv", "excel", "pdf", "print"],
  
  });

  let minDate, maxDate;

  // Custom filtering function which will search data in column four between two values
  DataTable.ext.search.push(function (settings, data, dataIndex) {
    let min = minDate.val();
    let max = maxDate.val();
    let date = new Date(data[6]);

    if (
      (min === null && max === null) ||
      (min === null && date <= max) ||
      (min <= date && max === null) ||
      (min <= date && date <= max)
    ) {
      return true;
    }
    return false;
  });

  // Create date inputs
  // Create date inputs
  minDate = new DateTime("#min", {
    format: "MMMM Do YYYY",
  });
  maxDate = new DateTime("#max", {
    format: "MMMM Do YYYY",
  });

  // Refilter the table
  document.querySelectorAll("#min, #max").forEach((el) => {
    el.addEventListener("change", () => table.draw());
  });
});

