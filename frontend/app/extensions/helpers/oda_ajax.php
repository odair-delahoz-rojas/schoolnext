<?php

class OdaAjax extends Ajax {

    public static function linkAction($action, $text, $update, $class = '', $attrs = '') {
        $lnk = Ajax::linkAction($action, $text, $update, $class, $attrs);
        return "<div class=\"w3-bar-item w3-button w3-mobile\">$lnk</div>";
    }
}