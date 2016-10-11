<? 
$row = 5;
$col = 1;

$cat = 0;
if($_REQUEST['cat']!='') $cat=killInjection($_REQUEST['cat']);

$p_new=0;
if ($_REQUEST['p_new']!='') $p_new=$_REQUEST['p_new'];
$sql = "select tbl_product.*,tbl_product_new.sort as sort from tbl_product_new,tbl_product where tbl_product_new.lang='".$_lang."' and tbl_product_new.product_id = tbl_product.id order by tbl_product_new.sort limit ".$row*$col*$p_new.",".$row*$col;
$result = @mysql_query($sql,$conn);
$total = countRecord("tbl_product_new","status=0 and lang='".$_lang."'");
if($total==0){
?>
<link href="../css/css.css" rel="stylesheet" type="text/css" />
<table align="center" cellSpacing="0" cellPadding="0" width="190" border="0">
	<tr><td height="20"></td></tr>
	<tr>
		<td align="center">
			<font color="#FFFFFF"><strong><?=$_lang=="vn"?'Sản phẩm mới đang cập nhật !':'Products are being updated !'?></strong></font>
		</td>
	</tr>
	<tr><td height="20"></td></tr>
</table>
<?
}else{
?>

<table align="center" cellspacing="0" cellpadding="0" width="190" border="0">
<?
for($i=0; $i<$row; $i++){
?>	
	<tr>			  	
		
<?
	for($j=0; $j<$col&&$products=mysql_fetch_assoc($result); $j++){
		$pro = getRecord("tbl_product","id=".$products['id'])?><td style="padding-bottom:4px">
			<table width="190" border="0" cellpadding="0" cellspacing="0" class="border_table" style="float:left">
                        <tr>
                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="5%">&nbsp;</td>
                                  <td width="91%"><table width="100%" height="140" border="0" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td align="center"><a class="tips" href="./?frame=product_detail&id=<?=$pro['id']?>">	                                                     <img src="<?=$pro['image']?>" width="85" height="76" border="0" />											
												</a>
											</td>
                                            </tr>
                                          <tr>
                                            <td align="center"><span style="font-family:Tahoma; color:#009900; font-size:12px; font-weight:600"><?=$pro['name']?></span></td>
                                            </tr>
                                          <tr>
                                            <td align="center"><b><?=$currencyUnit?></b>&nbsp;<span style="font-family:Tahoma; font-size:12px; color:#FF0000; font-weight:600"><?=number_format($pro['price'],0,',','.')?></span> </td>
                                            </tr>
                                        </table></td>
                                        <td width="4%">&nbsp;</td>
                                      </tr>
                            <tr>
                              <td valign="bottom"><img src="images/tab_center_1.jpg" width="5" height="5" /></td>
                                        <td></td>
                                        <td align="right" valign="bottom"><img src="images/tab_center_2.jpg" width="5" height="5" /></td>
                                      </tr>
                            </table></td>
                                </tr>
                        <tr>
                          <td class="tab_bg_center1">
						  	<?php
								if($pro['new']==1)
								{?>
									<div align="center" style="padding-top:4px">
										<img src="images/new.gif" border="0" align="left"/></div>                                       
								<? }
								else echo '';
							?>
						  		<a href="./?frame=product_detail&id=<?=$pro['id']?>" class="text_chitiet">
						  		CHI TIẾT</a>
						  </td>
                       </tr>
                </table>	
            <?
}
while($j<$col){
	echo "";
	$j=$j+1;
}
?></td>
	</tr>	  
<? }?>
</table>

<? }?>