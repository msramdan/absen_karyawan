<?php 

$string = "<div id=\"content\" class=\"app-content\">
<div class=\"col-md-6 ui-sortable\">
<div class=\"panel panel-inverse\" data-sortable-id=\"form-stuff-1\" data-init=\"true\">
<div class=\"panel-heading ui-sortable-handle\">
<h4 class=\"panel-title\">".ucfirst($table_name)." Read</h4>
<div class=\"panel-heading-btn\">
<a href=\"javascript:;\" class=\"btn btn-xs btn-icon btn-default\" data-toggle=\"panel-expand\" data-bs-original-title=\"\" title=\"\" data-tooltip-init=\"true\"><i class=\"fa fa-expand\"></i></a>
<a href=\"javascript:;\" class=\"btn btn-xs btn-icon btn-success\" data-toggle=\"panel-reload\"><i class=\"fa fa-redo\"></i></a>
<a href=\"javascript:;\" class=\"btn btn-xs btn-icon btn-warning\" data-toggle=\"panel-collapse\"><i class=\"fa fa-minus\"></i></a>
<a href=\"javascript:;\" class=\"btn btn-xs btn-icon btn-danger\" data-toggle=\"panel-remove\"><i class=\"fa fa-times\"></i></a>
</div>
</div>
<div class=\"panel-body\">
<table id=\"data-table-default\" class=\"table table-hover table-bordered table-td-valign-middle\">";
foreach ($non_pk as $row) {
    $string .= "\n\t    <tr><td>".label($row["column_name"])."</td><td><?php echo $".$row["column_name"]."; ?></td></tr>";
}
$string .= "\n\t    <tr><td></td><td><a href=\"<?php echo site_url(levelUser(\$this->session->userdata('level')).'/".$c_url."') ?>\" class=\"btn btn-default\">Cancel</a></td></tr>";
$string .= "\n\t</table>
			</div>
        </div>
    </div>
</div>";



$hasil_view_read = createFile($string, $target."views/" . $c_url . "/" . $v_read_file);

?>
