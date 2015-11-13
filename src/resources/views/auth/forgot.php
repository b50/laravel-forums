<!-- Styles -->
<style type="text/css">
    /* Desktop */
    @media (min-width: 979px) {
        .span7 .box {
            padding-left: 80px;
            padding-right: 80px;
        }
        .span5 .box {
            padding: 20px 40px;
        }
    }
</style>
<div class="col-md-7 center">
    <div class="box">
        <h2><?= __('Reset your password') ?></h2>
        <p><?= __('A link will be sent to your email address to reset your password. '); ?></p>
        <?= Form::open(NULL, array('autocomplete' => 'off', 'id' => 'form', 'class' => 'form-inline')); ?>
        <?php Form::messages($messages) ?>
            <div class="control-group <?= Form::control_state('username'); ?>">
                <?= Form::input('username', Arr::get($post, 'username') , array('class' => 'span3', 'placeholder' => 'Username')); ?>
                <?= Form::button('reset', 'Rest Password', array('type' => 'submit', 'class' => 'btn')); ?>
                <?= Form::help('username') ?>
            </div>
        <?= Form::close(); ?>
    </div>
</div>
