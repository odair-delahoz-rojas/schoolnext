<?php
declare(strict_types=1);
namespace AdminLTE;

// Cargar el autoloader de clases
//require_once __DIR__ . '/autoloader.php';

use AdminLTE\Components\Accordion;
use AdminLTE\Components\Alert;
use AdminLTE\Components\Badge;
use AdminLTE\Components\Callout;
use AdminLTE\Components\Card;
use AdminLTE\Components\DirectChat;
use AdminLTE\Components\Form;
use AdminLTE\Components\Modal;
use AdminLTE\Components\Pagination;
use AdminLTE\Components\ProgressBar;
use AdminLTE\Components\SmallBox;
use AdminLTE\Components\Table;
use AdminLTE\Components\Tabs;
use AdminLTE\Components\Timeline;
use AdminLTE\Components\Toast;
use AdminLTE\Components\Treeview;
use AdminLTE\Widgets\DescriptionList;
use AdminLTE\Widgets\InfoBox;
use AdminLTE\Widgets\ProductList;
use AdminLTE\Widgets\Ribbon;
use AdminLTE\Widgets\UserList;

/**
 * Clase AdminLTE (Facade)
 */
class AdminLTE {

    public static function card($title, $body, $options = []) {
        return Card::render($title, $body, $options);
    }

    public static function alert($message, $options = []) {
        return Alert::render($message, $options);
    }

    public static function smallBox($title, $number, $icon, $options = []) {
        return SmallBox::render($title, $number, $icon, $options);
    }

    public static function callout($content, $options = []) {
        return Callout::render($content, $options);
    }

    public static function tabs($tabs, $options = []) {
        return Tabs::render($tabs, $options);
    }

    public static function accordion($items, $options = []) {
        return Accordion::render($items, $options);
    }

    public static function directChat($title, $messages, $options = []) {
        return DirectChat::render($title, $messages, $options);
    }

    public static function timeline($items) {
        return Timeline::render($items);
    }

    public static function badge($text, $options = []) {
        return Badge::render($text, $options);
    }

    public static function progressBar($value, $options = []) {
        return ProgressBar::render($value, $options);
    }

    public static function pagination($currentPage, $totalPages, $options = []) {
        return Pagination::render($currentPage, $totalPages, $options);
    }

    public static function inputGroup($name, $options = []) {
        return Form::inputGroup($name, $options);
    }

    public static function customSwitch($name, $label, $options = []) {
        return Form::customSwitch($name, $label, $options);
    }

    public static function input($name, $label, $options = []) {
        return Form::input($name, $label, $options);
    }

    public static function textarea($name, $label, $options = []) {
        return Form::textarea($name, $label, $options);
    }

    public static function select($name, $label, $selectOptions, $options = []) {
        return Form::select($name, $label, $selectOptions, $options);
    }

    public static function customCheckbox($name, $label, $options = []) {
        return Form::customCheckbox($name, $label, $options);
    }

    public static function customRadio($name, $label, $options = []) {
        return Form::customRadio($name, $label, $options);
    }

    public static function treeview(array $items, array $options = []) {
        return Treeview::render($items, $options);
    }

    public static function table(array $headers, array $data, array $options = []) {
        return Table::render($headers, $data, $options);
    }

    public static function modal(string $id, string $title, string $body, array $options = []) {
        return Modal::render($id, $title, $body, $options);
    }

    public static function modalToggleButton(string $targetId, string $text, array $options = []) {
        return Modal::renderToggleButton($targetId, $text, $options);
    }

    public static function toast(string $id, string $title, string $body, array $options = []) {
        return Toast::render($id, $title, $body, $options);
    }

    public static function toastContainer(array $toasts) {
        return Toast::renderContainer($toasts);
    }

    public static function toastJsTriggerScript() {
        return Toast::renderJsTriggerScript();
    }

    public static function widgetInfoBox(string $text, string $number, string $icon, array $options = []) {
        return InfoBox::render($text, $number, $icon, $options);
    }

    public static function widgetUserList(string $title, array $users, array $options = []) {
        return UserList::render($title, $users, $options);
    }

    public static function widgetRibbon(string $text, array $options = []) {
        return Ribbon::render($text, $options);
    }

    public static function widgetProductList(string $title, array $products, array $options = []) {
        return ProductList::render($title, $products, $options);
    }

    public static function widgetDescriptionList(array $items, array $options = []) {
        return DescriptionList::render($items, $options);
    }
}