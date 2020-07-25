<style type="text/css">
*{
font-family: Arial;
margin:0px;
padding:0px;
}
@page {
 margin-left:3cm 2cm 2cm 2cm;
}
table.grid{
width:31.4cm ;
font-size: 9pt;
border-collapse:collapse;
}
table.grid th{
padding-top:1mm;
padding-bottom:1mm;
}
table.grid th{
background: #F0F0F0;
border-top: 0.2mm solid #000;
border-bottom: 0.2mm solid #000;
text-align:center;
padding-left:0.2cm;
border:1px solid #000;
}
table.grid tr td{
padding-top:0.5mm;
padding-bottom:0.5mm;
padding-left:2mm;
border-bottom:0.2mm solid #000;
border:1px solid #000;
}
h1{
font-size: 20pt;
}
h2{
font-size: 16pt;
}
h3{
font-size: 14pt;
}
.profil{
display: block;
width:31.4cm ;
font-size:10px;
margin:0px;
padding:0px;
}
.profil .koperasi{
font-size:14px;
font-weight:bold;
}
.header{
display: block;
width:31.4cm ;
margin-bottom: 0.3cm;
text-align: center;
}
.attr{
font-size:9pt;
width: 100%;
padding-top:2pt;
padding-bottom:2pt;
border-top: 0.2mm solid #000;
border-bottom: 0.2mm solid #000;
}
.pagebreak {
width:31.4cm ;
page-break-after: always;
margin-bottom:10px;
}
.akhir {
width:31.4cm ;
font-size:13px;
}
.page {
width:31.4cm ;
font-size:12px;
}

</style>
<?php
$profil = '<h3>'.$instansi.'</h3>';
$profil .= $alamat_instansi;
$judul = "NERACA LAJUR";
?>
<div class="profil"><?php echo $profil;?></div>
<div class="header"><h2><?php echo $judul;?></h2>
<h2>PERIODE : <?php echo $th;?></h2>
<p>Tanggal : <?php echo $this->app_model->tgl_indo(date('Y-m-d'));?></p>
</div>
<table class="grid">
<tr>
	<th rowspan="2">No</th>
    <th rowspan="2">No Rek</th>
    <th rowspan="2">Nama Rek</th>
    <th colspan="2">Neraca Saldo</th>
    <th colspan="2">AJP</th>
    <th colspan="2">NSSP</th>
    <th colspan="2">Laba/Rugi</th>
    <th colspan="2">Neraca</th>
</tr>
<tr>
    <th>Debet</th>
    <th>Kredit</th>
    <th>Debet</th>
    <th>Kredit</th>
    <th>Debet</th>
    <th>Kredit</th>
    <th>Debet</th>
    <th>Kredit</th>
    <th>Debet</th>
    <th>Kredit</th>
</tr>    
<?php
	if($data->num_rows()>0){
		$t_dr_ju = 0;
		$t_kr_ju = 0;
		$t_dr_ajp = 0;
		$t_kr_ajp = 0;
		$t_dr_nssp = 0;
		$t_kr_nssp = 0;
		$t_dr_lr = 0;
		$t_kr_lr = 0;
		$t_dr_n = 0;
		$t_kr_n = 0;
		$no =1;
		foreach($data->result_array() as $db){  
		$periode = $th-1;
		
		$ns = $this->app_model->neraca_saldo($db['no_rek'],$th);
		if($ns>0){
			$dr_ju = $ns;
			$kr_ju = 0;
		}else{
			$dr_ju = 0;
			$kr_ju = -1*$ns;
		}
		$dr_ajp = $this->app_model->dr_ajp($db['no_rek'],$th);
		$kr_ajp = $this->app_model->kr_ajp($db['no_rek'],$th);
		//nssp
		if(($dr_ju-$kr_ju)+($dr_ajp-$kr_ajp)>0){	
			$dr_nssp=($dr_ju-$kr_ju)+($dr_ajp-$kr_ajp);
		}else{
			$dr_nssp = 0;
		}
		if(($dr_ju-$kr_ju)+($dr_ajp-$kr_ajp)<0){		
			$kr_nssp=-1*(($dr_ju-$kr_ju)+($dr_ajp-$kr_ajp));
		}else{
			$kr_nssp = 0;
		}
		//rugi laba
		if(substr($db['no_rek'],0,1)>=4){
			$dr_lr = $dr_nssp;
			$kr_lr = $kr_nssp;
		}else{
			$dr_lr=0;
			$kr_lr=0;
		}
		//neraca
		if(substr($db['no_rek'],0,1)<4){
			$dr_n = $dr_nssp;
			$kr_n = $kr_nssp;
		}else{
			$dr_n=0;
			$kr_n=0;
		}
		
		?>    
    	<tr>
			<td align="center" width="20"><?php echo $no; ?></td>
            <td align="center" width="80" ><?php echo $db['no_rek']; ?></td>
            <td ><?php echo $db['nama_rek']; ?></td>
            <td align="right" width="80"><?php echo number_format($dr_ju); ?></td>
            <td align="right" width="80"><?php echo number_format($kr_ju); ?></td>
            <td align="right" width="80"><?php echo number_format($dr_ajp); ?></td>
            <td align="right" width="80"><?php echo number_format($kr_ajp); ?></td>
            <td align="right" width="80"><?php echo number_format($dr_nssp); ?></td>
            <td align="right" width="80"><?php echo number_format($kr_nssp); ?></td>
            <td align="right" width="80"><?php echo number_format($dr_lr); ?></td>
            <td align="right" width="80"><?php echo number_format($kr_lr); ?></td>
            <td align="right" width="80"><?php echo number_format($dr_n); ?></td>
            <td align="right" width="80"><?php echo number_format($kr_n); ?></td>
    </tr>
    <?php
		$t_dr_ju = $t_dr_ju+$dr_ju;
		$t_kr_ju = $t_kr_ju+$kr_ju;
		$t_dr_ajp = $t_dr_ajp+$dr_ajp;
		$t_kr_ajp = $t_kr_ajp+$kr_ajp;
		$t_dr_nssp = $t_dr_nssp+$dr_nssp;
		$t_kr_nssp = $t_kr_nssp+$kr_nssp;
		$t_dr_lr = $t_dr_lr+$dr_lr;
		$t_kr_lr = $t_kr_lr+$kr_lr;
		$t_dr_n = $t_dr_n+$dr_n;
		$t_kr_n = $t_kr_n+$kr_n;
		$no++;
		}
	}else{
		$t_dr_ju = 0;
		$t_kr_ju = 0;
		$t_dr_ajp = 0;
		$t_kr_ajp = 0;
		$t_dr_nssp = 0;
		$t_kr_nssp = 0;
		$t_dr_lr = 0;
		$t_kr_lr = 0;
		$t_dr_n = 0;
		$t_kr_n = 0;
	?>
    	<tr>
        	<td colspan="9" align="center" >Tidak Ada Data</td>
        </tr>
    <?php	
	}
?>
<tr>
	<td colspan="3" align="center">Saldo</td>
    <td align="right"><?php echo number_format($t_dr_ju);?></td>
    <td align="right"><?php echo number_format($t_kr_ju);?></td>
    <td align="right"><?php echo number_format($t_dr_ajp);?></td>
    <td align="right"><?php echo number_format($t_kr_ajp);?></td>
    <td align="right"><?php echo number_format($t_dr_nssp);?></td>
    <td align="right"><?php echo number_format($t_kr_nssp);?></td>
    <td align="right"><?php echo number_format($t_dr_lr);?></td>
    <td align="right"><?php echo number_format($t_kr_lr);?></td>
    <td align="right"><?php echo number_format($t_dr_n);?></td>
    <td align="right"><?php echo number_format($t_kr_n);?></td>
</tr>
<tr>
	<?php 
	$lr = $t_kr_lr-$t_dr_lr;
	$s_dr_lr = $lr+$t_dr_lr;
	$s_kr_n = $lr+$t_kr_n;
	?>
	<td colspan="9"></td>
    <td align="right"><?php echo number_format($lr);?></td>
    <td colspan="2"></td>
    <td align="right"><?php echo number_format($lr);?></td>
</tr>    
<tr>
	<td colspan="9"></td>
	<td align="right"><?php echo number_format($s_dr_lr);?></td>
    <td align="right"><?php echo number_format($t_kr_lr);?></td>
    <td align="right"><?php echo number_format($t_dr_n);?></td>
    <td colspan="10" align="right"><?php echo number_format($s_kr_n);?></td>
</tr>
</table>