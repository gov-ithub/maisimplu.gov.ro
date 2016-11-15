<?php
switch($this->request('view')):
    case 'setting':
        $this->get_template('/admin/setting');
        break;
    default:
        $this->get_template('/admin/admin');
        break;
endswitch;
?>