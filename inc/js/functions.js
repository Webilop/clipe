
/*
 * var: table and select => selector jquery
 */
function clipe_add_product(table,select){
  console.log(table);
  row='<tr>'+
          '<td>'+jQuery(select+" option:selected" ).text()+'<input type="hidden" value="'+jQuery(select).val()+'" name="product_id[]"/></td>'+
          '<td><input value="1" type="number" name="quantity[]"/></td>'+
          '<td>'+
            '<a onclick="clipe_remove_product(this);"><i class="fa fa-trash-o"></i></a>'+
          '</td>'+
        '</tr>';
        console.log(jQuery(table+' > tbody'));
  jQuery(table+' > tbody').append(row);
  //jQuery(table).insertRow(-1);
}

function clipe_remove_product(element){
  jQuery(element).closest("tr").remove();
}

/**
 * Add confirmation window to links to delete elements
 */
var confirmDeletionMessage;
jQuery(document).ready(function(){
  jQuery(".actions a.delete").click(function(){
    return confirm(confirmDeletionMessage);
  });
});

/**
 * Add confirmation window to links to cancel orders
 */
var confirmCancelMessage;
jQuery(document).ready(function(){
  jQuery(".actions a.cancel").click(function(){
    var orderId = jQuery(this).parent().find("input:hidden[id=id]").val();
    var i = confirmCancelMessage.indexOf('?');
    var message = confirmCancelMessage.substring(0,i);
    return confirm(message+' '+orderId+'?');
  });
});

