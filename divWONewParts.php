<?
    require_once("inc/global.php"); 
    require_once(MODEL_PATH . SESSION_MODEL);

    $lbr = $_GET['lbr'];
    $misc = $_GET['misc'];
    $disc = $_GET['disc'];
    $qty = $_GET['qty'];
    $price = $_GET['price'];
    $itemid = $_GET['itemid'];
    $curParts = $_GET['parts'];
    
    // SET FMS DB
    $fms_db = new DBConfig;
    $fms_db->setFleetDB();

    // SET PARTS
    $getParts = new Table;
    $getParts->setSQLType($fms_db->getSQLType());
    $getParts->setInstance($fms_db->getInstance());
    $getParts->setView("v_partsmaster");
    $getParts->setParam("WHERE partsID = '$itemid'");
    $getParts->doQuery("query");
    $row_getParts = $getParts->getLists();
    $num_getParts = $getParts->getNumRows();

    // PARTS INFO
    $pId = $row_getParts[0]['partsID'];
    $pDesc = $row_getParts[0]['description'];

    // CLOSING FMS DB
    $fms_db->DBClose();

    if($curParts != ""){
        if($num_getParts > 0){
            $xCurParts = explode("|",$curParts);
            $naa = 0;
            $nParts = null;
            for($a=0;$a<count($xCurParts);$a++){
                $y = $xCurParts[$a];
                $z = explode(":",$y);

                // RECONSTRUCT FOR CHECKING ITEM EXISTED
                if($z[0] != $pId){
                    $nParts .= $xCurParts[$a] . '|';
                }else{
                    $naa++;
                    $nParts .= $pId . ':' . $pDesc . ':' . $price . ':' . $qty . '|';
                }
            }

            // CHECK IF NOT EXISTED
            if($naa == 0){
                $nParts .= $pId . ':' . $pDesc . ':' . $price . ':' . $qty . '|';
            }
        }
    }else{
        $nParts .= $pId . ':' . $pDesc . ':' . $price . ':' . $qty;
    }

    $nArrParts = rtrim($nParts,"|");
?>
<span id="divCost">
<div class="form-group">
    <table class="table table-hover table-condensed table-striped table-responsive table-bordered">
        <tr>
            <th>#</th>
            <th>Desc</th>
            <th>Price(Qty)</th>
            <th>Total</th>
            <th>Remove</th>
        </tr>
        <? 
            $cnt = 1; 
            $partsCost = 0;
            $row = explode("|",$nArrParts);
            $totalcost = 0;
            for($i=0;$i<count($row);$i++){
                $item = explode(":",$row[$i]);
                if($item[0] != null){
                    $itemid = $item[0];
                    $itemdesc = $item[1];
                    $itemprice = $item[2];
                    $itemqty = $item[3];
                    $str = number_format($itemprice,2) . ' (' . $itemqty . ')';
                    $total = ($itemprice * $itemqty);

                    $partsCost += $total;
                    $totalqty += $itemqty;
        ?>
        <tr>
            <td><?=$cnt;?></td>
            <td><?=$itemdesc;?></td>
            <td align="center"><?=$str;?></td>
            <td align="right"><?=number_format($total,2);?></td>
            <td align="center">
                <a href="#" onClick="removeParts('<?=$itemid;?>');">
                    <span class="fa fa-trash"></span>
                </a>
            </td>
        </tr>
        <?
                    $cnt++;
                }
            }
        ?>
        <tr>
            <td colspan="2" align="right"><b>TOTAL >>>></b></td>
            <td align="center"><b><?=$totalqty;?></b></td>
            <td align="right"><b><?=number_format($partsCost,2);?></b></td>
            <td align="center">&nbsp;</td>
        </tr>
        <?
            $subTotal = (($lbr + $misc + $partsCost) - $disc);
            $tax = ($subTotal * .12);
            $totalCost = ($subTotal + $tax);
        ?>
    </table>
    <input type="hidden" name="txtPartsArray" id="txtPartsArray" value="<?=$nArrParts;?>" />
</div>
<div class="form-group">&nbsp;</div>
<div class="form-group">
    <label class="col-lg-3" for="txtLabor">Labor</label>
    <div class="col-lg-4">
        <input type="text" value="<?=number_format($lbr,2);?>" name="txtLabor" id="txtLabor" class="form-control gui-input input-sm" onBlur="getTotalCost();" placeholder="0.00" />
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3" for="txtMiscellaneous">Miscellaneous</label>
    <div class="col-lg-4">
        <input type="text" value="<?=number_format($misc,2);?>" name="txtMiscellaneous" id="txtMiscellaneous" class="form-control gui-input input-sm" onBlur="getTotalCost();" placeholder="0.00" />
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3" for="txtParts">Parts</label>
    <div class="col-lg-4">
        <input type="text" value="<?=number_format($partsCost,2);?>" name="txtParts" id="txtParts" readonly class="form-control gui-input input-sm" onBlur="getTotalCost();" placeholder="0.00" />
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3" for="txtDiscount">Discount</label>
    <div class="col-lg-4">
        <input type="text" value="<?=number_format($disc,2);?>" name="txtDiscount" id="txtDiscount" class="form-control gui-input input-sm" onBlur="getTotalCost();" placeholder="0.00" />
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3" for="txtSubTotal">Sub-Total</label>
    <div class="col-lg-4">
        <input type="text" value="<?=number_format($subTotal,2);?>" name="txtSubTotal" id="txtSubTotal" readonly class="form-control gui-input input-sm" placeholder="0.00" />
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3" for="txtTax">Tax</label>
    <div class="col-lg-4">
        <input type="text" value="<?=number_format($tax,2);?>" name="txtTax" id="txtTax" readonly class="form-control gui-input input-sm" placeholder="0.00" />
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3" for="txtTotalCost">Total</label>
    <div class="col-lg-4">
        <input type="text" value="<?=number_format($totalCost,2);?>" name="txtTotalCost" id="txtTotalCost" readonly class="form-control gui-input input-sm" placeholder="0.00" />
    </div>
</div>
</span>
<script type="text/javascript" src="assets/js/jquery.price_format.2.0.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        // NUMBERS w/ DECIMAL AND COMMA
        $('#txtLabor,#txtMiscellaneous,#txtParts,#txtDiscount,#txtTax,#txtTotalCost,#txtSubTotal').priceFormat({
            clearPrefix: true,
            prefix: '',
            centsSeparator: '.',
            thousandsSeparator: ',',
            centsLimit: 2
        });
    });
</script>