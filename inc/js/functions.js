
/*
 * var: table and select => selector jquery
 */
var products;
function inArray(value, array) {
  leng = array.length;
  for (i = 0; i < leng; i++) {
    if (array[i] == value) {
      return true;
    }
  }
  return false;
}

function deleteArray(value, array) {
  leng = array.length;
  for (i = 0; i < leng; i++) {
    if (array[i] == value) {
      array.splice(i, 1);
    }
  }
}
function clipe_add_product(table, select) {
  var productID = jQuery(select).val();
  if (!inArray(productID, products)) {
    products[products.length] = productID;
    row = '<tr>' +
            '<td>' + jQuery(select + " option:selected").text() + '<input type="hidden" value="' + productID + '" name="product_id[]"/></td>' +
            '<td class="quantity"><input class="form-control quantity-input" value="1" type="number" name="quantity[]"/></td>' +
            '<td class="actions">' +
            '<a onclick="clipe_remove_product(this,'+ productID +');"><i class="fa fa-trash-o"></i></a>' +
            '</td>' +
            '</tr>';
    jQuery(table + ' > tbody').append(row);
  }
  //jQuery(table).insertRow(-1);
}

function clipe_remove_product(element,productID) {  
  jQuery(element).closest("tr").remove();  
  deleteArray(productID,products);  
}

/**
 * Add confirmation window to links to delete elements
 */
var confirmDeletionMessage;
jQuery(document).ready(function () {
  jQuery(".actions a.delete").click(function () {
    return confirm(confirmDeletionMessage);
  });
});

/**
 * Add confirmation window to links to cancel orders
 */
var confirmCancelMessage;
jQuery(document).ready(function () {
  jQuery(".actions a.cancel").click(function () {
    var orderId = jQuery(this).parent().find("input:hidden[id=id]").val();
    var i = confirmCancelMessage.indexOf('?');
    var message = confirmCancelMessage.substring(0, i);
    return confirm(message + ' ' + orderId + '?');
  });
});

