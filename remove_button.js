function removeRow(btn) {
    var row = btn.parentNode.parentNode;
    var confirmRemove = confirm("Are you sure you want to remove this course?");
    if (confirmRemove) {
      row.parentNode.removeChild(row);
    }
  }
  