<h1 class="text-center">Activate your account</h1>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="box">
            <div class="box-section" style="padding: 20px">
                <p><?= __('You have been sent an email with instructions on how to activate your account. If you don\'t recive the email check you spam folder or send an email to calumks@gmail.com and i\'ll help you out.') ?></p>
                <?= Form::open(null, array('autocomplete' => 'off', 'role' => 'form', 'id' => 'form')) ?>
                <?php Form::messages($messages) ?>
                <div class="form-group <?= Form::control_state('email'); ?>">
                    <?= Form::label('email', 'Email address', array('class' => 'sr-only')); ?>
                    <?= Form::input('email', Session::instance()->get('activation'),
                        array('class' => 'form-control', 'placeholder' => __('Email'))); ?>
                </div>
                <?= Form::button('resend', 'Resend', array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
                <?= Form::close(); ?>
            </div>
        </div>
    </div>
</div>
