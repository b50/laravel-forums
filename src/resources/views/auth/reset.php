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

<!-- Validate -->
<script>
    $(document).ready(function(){
       $("#form").validate({
            rules: {
                password: {
                    minlength: 6,
                    required: true,
                },
                confirm: {
                    equalTo: '#password',
                },
            },
            messages: {
                password: {
                    minlengh: "<?= __('Password must be at least 6 characters') ?>",
                    required: "<?= __('You must enter a password') ?>",
                },
                confirm: {
                    equalTo: "<?= __('The passwords did not match') ?>",
                },
            },
            highlight: function (element, errorClass, validClass) {
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).closest('.control-group').removeClass('error').addClass('success');
            },
            success: function (label) {
                $(label).closest('form').find('.valid').removeClass("invalid");
            },
            errorPlacement: function (error, element) {
                element.closest('.control-group').find('.help-block').html(error.text());
            }
         });
    });
</script>

<div class="col-md-7 center">
    <div class="box">
        <h2><?= __('Reset your password') ?></h2>
        <?= Form::open(NULL, array('autocomplete' => 'off', 'id' => 'form')) ?>
        <?php Form::messages($messages) ?>
           <div class="control-group <?= Form::control_state('password'); ?>">
                    <?= Form::label('password', 'Password', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?= Form::password('password', Arr::get($post, 'password'), array('class' => 'span4', 'id' => 'password')); ?>
                    <?= Form::help('password') ?>
                </div>
            </div>
            <div class="control-group <?= Form::control_state('confirm'); ?>">
                    <?= Form::label('confirm', 'Confirm Password', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?= Form::password('confirm', Arr::get($post, 'confirm'), array('class' => 'span4')); ?>
                    <?= Form::help('confirm') ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <?= Form::button('change', 'Change password', array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
                </div>
            </div>
        <?= Form::close(); ?>
    </div>
</div>
