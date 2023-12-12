<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Acceso al Sistema';
$this->params['breadcrumbs'][] = $this->title;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../web/css/login.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;500;700&display=swap" rel="stylesheet">
    <!-- normalize cnd-->
    <link rel="stylesheet" href="../web/css/normalize.css">

</head>

<body>
    <div class="form-container shadow">
        <!-- Rectángulo decorativo superior -->
        <div class="rectangulo_sup"></div>
        <!-- Línea decorativa de puntos -->
        <div class="dotted-line"></div>

        <!-- Título del formulario -->
        <p class="title"><?= Html::encode($this->title) ?></p>
        
        <!-- Imagen del encabezado 
        <img src="<?= Url::to('@web/archivos/avatar.png', true); ?>" width="40%" height="25%" BORDER="0" ALT="Imagen de Encabezado">
        -->

        <!-- Formulario de inicio de sesión -->
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <!-- Campo de entrada para el nombre de usuario -->
            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Username') ?>
            <!-- Campo de entrada para la contraseña -->
            <?= $form->field($model, 'password')->passwordInput()->label('Password') ?>
            <div  class="flex">
              <!-- Casilla de verificación "Recordarme" -->
              <div class="check">
                <?= $form->field($model, 'rememberMe')->checkbox()->label('Recordarme') ?>
              </div>
  
              <!-- Enlace "Forgot Password" -->
              <div class="forgot">
                  <a rel="noopener noreferrer" href="http://transferencia.valladolid.tecnm.mx/frontend/web/index.php?r=site%2Frequest-password-reset" id="liga">Forgot Password ?</a>
              </div>
            </div>
            <!-- Botón de inicio de sesión -->
            <button class="sign">Sign in</button>
            
        <?php ActiveForm::end(); ?>

        <!-- Mensaje "Login with social accounts" -->
        <div class="social-message">
            <!-- Línea horizontal decorativa -->
            <div class="line"></div>
            <!-- Texto del mensaje -->
            <p class="message">Login with social accounts</p>
            <!-- Otra línea horizontal decorativa -->
            <div class="line"></div>
        </div>

        <!-- Iconos de redes sociales -->
        <div class="social-icons">

            <button aria-label="Log in with Google" class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 488 512">
                  <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                  <path d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"/>
                </svg>
            </button>

            <button aria-label="Log in with Twitter" class="icon">
              <!-- Icono de Twitter -->
              <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
              </svg>
            </button>

            <button aria-label="Log in with Facebook" class="icon">
              <!-- Icono de Facebook -->
              <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/>
              </svg>       
            </button>
        </div>

        <!-- Enlace "Sign up" -->
        <p class="signup">Don't have an account? <a rel="noopener noreferrer" href="#" class="">Sign up</a></p>

          <div class="rectangulo_inf"></div>
          <div class="dotted-line_inf"></div>
          
        <!-- Rectángulo decorativo inferior -->
        <!-- Línea decorativa de puntos -->

    </div>
</body>
</html>
