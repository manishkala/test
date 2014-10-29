<?php
session_start();
if(isset($_GET['sym']) && $_GET['sym'] != ''){
    $url = 'http://data.benzinga.com/stock/'. $_GET['sym'];
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $url);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));
    $buffer = curl_exec($curl_handle);
    curl_close($curl_handle);
    $buffer = json_decode($buffer, TRUE);
    $_SESSION['amount'] = 100000;
    //echo '<pre>'; print_r($buffer);exit;
    if(isset($buffer['status']) && $buffer['status']=='error'){
        echo '<td id="buysell" colspan="2" align="center">'.$buffer['msg'].'</td>';
    }else{
?>

<td id="buysell">
    <table style="width:100%">
    <tr>
      <td><?php echo $buffer['name']; ?><input type="hidden" class="share_name"  value="<?php echo $buffer['symbol'];?>"/></td>
    </tr>
    <tr>
        <td class="inner">
            <table style="width:100%">
            <tr>
              <th>Bid</th>
              <th>Ask</th> 
            </tr>
            <tr>
              <td><?php echo $buffer['bid'];?><input type="hidden" class="bid" name="bid"  value="<?php echo $buffer['bid'];?>"/></td>
              <td><?php echo $buffer['ask'];?><input type="hidden" class="ask" name="ask"  value="<?php echo $buffer['ask'];?>"/></td> 
            </tr>
          </table>
            <script>
        
          $(".buy").click(function(){ 
            var qty = $("#qty").val();
            var comp = $(".share_name").val(); 
            var price = $(".ask").val();
            var total = <?php echo $_SESSION['amount']; ?>;
            var prc = qty * price;
            if(total< prc){
                alert('Sorry, you are unable to buy because you dont have that much amount.');
                return false;
            }
            var str = comp;
            str = str.replace(/ +/g, "");
            var chk = str;
            if($('#qty_'+chk).length == 0){
                $("#stock_tbl").append('<tr id="stock'+chk+'"></tr>');
            }
            if($('#qty_'+str).length > 0){
                var old_qty = $('#qty_'+str).html();
                var old_price = $('#price_'+str).html();
                $("#stock"+chk).load("ajax.php?type=buy&qty="+qty+'&comp='+escape(comp)+'&price='+price+'&old_qty='+old_qty+'&old_price='+old_price );
            }else{
                $("#stock"+chk).load("ajax.php?qty="+qty+'&comp='+escape(comp)+'&price='+price );                
            }
            $("#total_p").load("ajax.php?qtyb="+qty+'&price='+price );
          });
          
          $(".sell").click(function(){ 
            var qty = $("#qty").val();
            var comp = $(".share_name").val();
            var price = $(".bid").val();
            
            var str = comp;
            str = str.replace(/ +/g, "");
            var chk = str;
            if($('#qty_'+chk).length == 0){
                $("#stock_tbl").append('<tr id="stock'+chk+'"></tr>');
            }
            if($('#qty_'+str).length > 0){
                var old_qty = $('#qty_'+str).html();
                var old_price = $('#price_'+str).html();
                if(old_qty < qty){
                    alert('Sell quantity should not exceed than your stock quantity.');
                    return false;
                }
                $("#stock_tbl").append('<tr id="stock'+str+'"></tr>');
                $("#stock"+chk).load("ajax.php?type=sell&qty="+qty+'&comp='+escape(comp)+'&price='+price+'&old_qty='+old_qty+'&old_price='+old_price );                
            }else{
                $("#stock"+chk).load("ajax.php?type=buy&qty="+qty+'&comp='+escape(comp)+'&price='+price );                
            }
            $("#total_p").load("ajax.php?qtyc="+qty+'&price='+price );
          });
        
        </script>
        </td>
    </tr>
    <tr>
      <td><input type="text" name="qty" id="qty" />
          <input type="submit" name="buy" id="buy" class="buy" value="Buy"/>
          <input type="submit" name="sell" id="sell" class="sell" value="Sell"/></td>
    </tr>
    </table>
</td>
<td>
    <table style="width:100%">
        <tr>
            <th>Current Portfolio</th>
           <th id="total_p">Cash: $<?php echo $_SESSION['amount']; ?></th>
        </tr>
        <tr>
            <td  colspan="2" class="inner">
                <table style="width:100%"  id="stock_tbl">
                    <tr>
                       <th>Company</th>
                       <th>Quantity</th>
                       <th>Price Paid</th>
                       <th>Action</th>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</td>

<?php
    }
}

if(isset($_GET['syms']) && $_GET['syms'] != ''){
    $url = 'http://data.benzinga.com/stock/'. $_GET['syms'];
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $url);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));
    $buffer = curl_exec($curl_handle);
    curl_close($curl_handle);
    $buffer = json_decode($buffer, TRUE);
    //echo '<pre>'; print_r($buffer);exit;
    if(isset($buffer['status']) && $buffer['status']=='error'){
        echo '<table style="width:100%"><tr><td align="center">'.$buffer['msg'].'</td></tr></table>';
    }else{
?>

<table style="width:100%">
    <tr>
      <td><?php echo $buffer['name']; ?><input type="hidden" class="share_name"  value="<?php echo $buffer['name'];?>"/></td>
    </tr>
    <tr>
        <td class="inner">
            <table style="width:100%">
            <tr>
              <td>Bid</td>
              <td>ask</td> 
            </tr>
            <tr>
              <td><?php echo $buffer['bid'];?><input type="hidden" class="bid" name="bid"  value="<?php echo $buffer['bid'];?>"/></td>
              <td><?php echo $buffer['ask'];?><input type="hidden" class="ask" name="ask"  value="<?php echo $buffer['ask'];?>"/></td> 
            </tr>
          </table>
            <script>
        
          $(".buy").click(function(){ 
            var qty = $("#qty").val();
            var comp = $(".share_name").val(); 
            var price = $(".ask").val();
            var total = <?php echo $_SESSION['amount']; ?>;
            var prc = qty * price;
            if(total< prc){
                alert('Sorry, you are unable to buy because you dont have that much amount.');
                return false;
            }
            var str = comp;
            str = str.replace(/ +/g, "");
            var chk = str;
            if($('#qty_'+chk).length == 0){
                $("#stock_tbl").append('<tr id="stock'+chk+'"></tr>');
            }
            if($('#qty_'+str).length > 0){
                var old_qty = $('#qty_'+str).html();
                var old_price = $('#price_'+str).html();
                $("#stock"+chk).load("ajax.php?type=buy&qty="+qty+'&comp='+escape(comp)+'&price='+price+'&old_qty='+old_qty+'&old_price='+old_price );
            }else{
                $("#stock"+chk).load("ajax.php?qty="+qty+'&comp='+escape(comp)+'&price='+price );                
            }
            $("#total_p").load("ajax.php?qtyb="+qty+'&price='+price );
          });
          
          $(".sell").click(function(){ 
            var qty = $("#qty").val();
            var comp = $(".share_name").val();
            var price = $(".bid").val();
            
            var str = comp;
            str = str.replace(/ +/g, "");
            var chk = str;
            if($('#qty_'+chk).length == 0){
                $("#stock_tbl").append('<tr id="stock'+chk+'"></tr>');
            }
            if($('#qty_'+str).length > 0){
                var old_qty = $('#qty_'+str).html();
                var old_price = $('#price_'+str).html();
                if(old_qty < qty){
                    alert('Sell quantity should not exceed than your stock quantity.');
                    return false;
                }
                $("#stock"+chk).load("ajax.php?type=sell&qty="+qty+'&comp='+escape(comp)+'&price='+price+'&old_qty='+old_qty+'&old_price='+old_price );                
            }else{
                $("#stock"+chk).load("ajax.php?type=buy&qty="+qty+'&comp='+escape(comp)+'&price='+price );                
            }
            $("#total_p").load("ajax.php?qtyc="+qty+'&price='+price );
          });
        
        </script>
        </td>
    </tr>
    <tr>
      <td><input type="text" name="qty" id="qty" />
          <input type="submit" name="buy" id="buy" class="buy" value="Buy"/>
          <input type="submit" name="sell" id="sell" class="sell" value="Sell"/></td>
    </tr>
    </table>
<?php
}
}

if(isset($_GET['qty']) && $_GET['qty'] != ''){
    if(isset($_GET['old_price']) && $_GET['old_price'] != '' ){
        if($_GET['type'] == 'buy'){
            $price = ($_GET['qty']*$_GET['price'])+ $_GET['old_price'];
            $qty = $_GET['qty'] + $_GET['old_qty'];
        }else{
            $price = $_GET['old_price'] - ($_GET['qty']*$_GET['price']);
            $qty = $_GET['old_qty'] - $_GET['qty'];
        }
    }else{
        $price = $_GET['qty']*$_GET['price'];
        $qty = $_GET['qty'] ;
    }
    $name = explode(" ", $_GET['comp']);
    $name = implode("", $name);
 ?>
<td><?php echo $_GET['comp']; ?></td>
<td id="qty_<?php echo $name;?>"><?php echo $qty; ?></td>
<td id="price_<?php echo $name;?>"><?php echo $price; ?></td>
<td><input type="button" name="btn" id="btn" value="View Stock"/></td>
<?php
}

if(isset($_GET['qtyb']) && $_GET['qtyb'] != ''){ 
    $price = $_GET['qtyb']*$_GET['price'];
    $price = $_SESSION['amount']-$price;
    $_SESSION['amount'] = $price;
    echo 'Cash: $'.$_SESSION['amount'];
}

if(isset($_GET['qtyc']) && $_GET['qtyc'] != ''){ 
    $price = $_GET['qtyc']*$_GET['price'];
    $price = $_SESSION['amount']+$price;
    $_SESSION['amount'] = $price;
    echo 'Cash: $'.$_SESSION['amount'];
}
?>
