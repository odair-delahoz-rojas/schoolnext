<?php
// require_once __DIR__ . '/../autoloader.php';

use AdminLTE\Components\Form;
use AdminLTE\Components\Card;

$formContent = '';

// 1. Text Input
$formContent .= Form::text('user_name', 'Username', ['placeholder' => 'Enter username', 'help_text' => 'Your public name.']);

// 2. Email and Password Inputs
$formContent .= Form::email('email', 'Email Address', ['placeholder' => 'user@example.com']);
$formContent .= Form::password('password', 'Password');

// 3. Textarea
$formContent .= Form::textarea('bio', 'Biography', ['rows' => 4, 'placeholder' => 'Tell us about yourself...']);

// 4. Select Dropdown
$selectOptions = ['' => 'Please select', '1' => 'Option 1', '2' => 'Option 2', '3' => 'Option 3'];
$formContent .= Form::select('user_role', 'User Role', $selectOptions, ['selected_value' => '2']);

$formContent .= '<hr>';

// 5. New Input Types
$formContent .= '<h5>New Input Types</h5>';
$formContent .= Form::file('profile_picture', 'Profile Picture');
$formContent .= Form::date('start_date', 'Start Date');
$formContent .= Form::range('satisfaction', 'Satisfaction Level', ['min' => 0, 'max' => 100, 'step' => 1, 'value' => 75]);

$formContent .= '<hr>';

// 6. Validation Errors
$formContent .= '<h5>Validation Errors</h5>';
$formContent .= Form::text('first_name', 'First Name', ['value' => 'John', 'error' => 'Please enter a valid first name.']);
$formContent .= Form::select('country', 'Country', ['' => 'Select a country', 'US' => 'United States'], ['error' => 'This field is required.']);


$formContent .= '<hr>';

// 7. Checkboxes
$formContent .= '<h5>Settings</h5>';
$formContent .= Form::customCheckbox('notifications', 'Enable notifications', ['checked' => true]);
$formContent .= Form::customCheckbox('newsletter', 'Subscribe to newsletter');

$formContent .= '<hr>';

// 8. Radio Buttons
$formContent .= '<h5>Account Type</h5>';
$formContent .= Form::customRadio('account_type', 'Free', ['value' => 'free', 'checked' => true]);
$formContent .= Form::customRadio('account_type', 'Pro', ['value' => 'pro']);
$formContent .= Form::customRadio('account_type', 'Enterprise', ['value' => 'enterprise']);

$formContent .= '<hr>';

// 9. Input Groups
$formContent .= '<h5>Input Groups</h5>';
$formContent .= Form::inputGroup('twitter_handle', ['prepend' => '@']);
$formContent .= Form::inputGroup('price', ['append' => '.00']);
$formContent .= Form::inputGroup('website', ['prepend' => 'https://', 'append' => '.com']);

$formContent .= '<hr>';

// 10. Custom Switches
$formContent .= '<h5>Switches</h5>';
$formContent .= Form::customSwitch('dark_mode', 'Enable Dark Mode');
$formContent .= Form::customSwitch('maintenance', 'Enable Maintenance Mode', ['checked' => true]);

$cardFooter = '<button type="submit" class="btn btn-primary">Submit</button> <button type="reset" class="btn btn-secondary">Reset</button>';

$fullForm = '<form>' . $formContent . '</form>';

echo Card::render('Comprehensive Form Example', $fullForm, ['color' => 'primary', 'outline' => true, 'footer' => $cardFooter]);