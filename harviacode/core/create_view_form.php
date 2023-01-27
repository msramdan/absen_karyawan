<?php 

$string = "<div id=\"content\" class=\"app-content\">
<div class=\"col-md-6 ui-sortable\">
<div class=\"panel panel-inverse\" data-sortable-id=\"form-stuff-1\" style=\"\" data-init=\"true\">

<div class=\"panel-heading ui-sortable-handle\">
<h4 class=\"panel-title\">KELOLA DATA ".  strtoupper($table_name)."</h4>
<div class=\"panel-heading-btn\">
<a href=\"javascript:;\" class=\"btn btn-xs btn-icon btn-default\" data-toggle=\"panel-expand\" data-bs-original-title=\"\" title=\"\" data-tooltip-init=\"true\"><i class=\"fa fa-expand\"></i></a>
<a href=\"javascript:;\" class=\"btn btn-xs btn-icon btn-success\" data-toggle=\"panel-reload\"><i class=\"fa fa-redo\"></i></a>
<a href=\"javascript:;\" class=\"btn btn-xs btn-icon btn-warning\" data-toggle=\"panel-collapse\"><i class=\"fa fa-minus\"></i></a>
<a href=\"javascript:;\" class=\"btn btn-xs btn-icon btn-danger\" data-toggle=\"panel-remove\"><i class=\"fa fa-times\"></i></a>
</div>
</div>
<div class=\"panel-body\">
        
            <form action=\"<?php echo \$action; ?>\" method=\"post\">
            <thead>
            <table id=\"data-table-default\" class=\"table  table-bordered table-hover table-td-valign-middle\">";
foreach ($non_pk as $row) {
    if ($row["data_type"] == 'text')
    {
    $string .= "\n\t    
        <tr><td >".label($row["column_name"])." <?php echo form_error('".$row["column_name"]."') ?></td><td> <textarea class=\"form-control\" rows=\"3\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\"><?php echo $".$row["column_name"]."; ?></textarea></td></tr>";
    }elseif($row["data_type"]=='email'){
        $string .= "\n\t    <tr><td >".label($row["column_name"])." <?php echo form_error('".$row["column_name"]."') ?></td><td><input type=\"email\" class=\"form-control\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\" value=\"<?php echo $".$row["column_name"]."; ?>\" /></td></tr>";    
    }
    elseif($row["data_type"]=='date'){
        $string .= "\n\t    <tr><td >".label($row["column_name"])." <?php echo form_error('".$row["column_name"]."') ?></td><td><input type=\"date\" class=\"form-control\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\" value=\"<?php echo $".$row["column_name"]."; ?>\" /></td></tr>";    
        } 
    else
    {
    $string .= "\n\t    <tr><td >".label($row["column_name"])." <?php echo form_error('".$row["column_name"]."') ?></td><td><input type=\"text\" class=\"form-control\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\" value=\"<?php echo $".$row["column_name"]."; ?>\" /></td></tr>";
    }
}
$string .= "\n\t    <tr><td></td><td><input type=\"hidden\" name=\"".$pk."\" value=\"<?php echo $".$pk."; ?>\" /> ";
$string .= "\n\t    <button type=\"submit\" class=\"btn btn-danger\"><i class=\"fas fa-save\"></i> <?php echo \$button ?></button> ";
$string .= "\n\t    <a href=\"<?php echo site_url(levelUser(\$this->session->userdata('level')).'/".$c_url."') ?>\" class=\"btn btn-info\"><i class=\"fas fa-undo\"></i> Kembali</a></td></tr>
</thead>";
$string .= "\n\t</table></form>        </div>
</div>
</div>
</div>";

$hasil_view_form = createFile($string, $target."views/" . $c_url . "/" . $v_form_file);

?>
