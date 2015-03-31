
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


