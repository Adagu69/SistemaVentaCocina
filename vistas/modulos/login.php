
<div class="login-box">

  <div class="login-box-body">

    <p class="login-box-msg">Bienvenido al Panel de control de Cafeteria-CMS</p>

    <form method="post">

      <div class="form-group has-feedback">

        <input type="text" class="form-control" placeholder="Usuario" name="ingUsuario" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>

      </div>

      <div class="form-group has-feedback">

        <input type="password" class="form-control" placeholder="Contraseña" name="ingPassword" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      
      </div>

       <!-- Recuérdame alineado a la derecha -->
       <div class="form-group text-left">
        <label style="font-weight: normal;">
          <input type="checkbox" name="recordar" style="margin-right:5px;"> Recuérdame
        </label>
      </div>


      <div class="row">
        <div class="form-group text-center">
          <button type="submit" class="btn btn-primary btn-block" style="max-width: 150px; margin: 0 auto;">Ingresar</button>
        </div>
      </div>

      <!-- Enlaces -->
      <div class="text-center" style="margin-top: 10px; font-size: 14px;">
        <a href="recuperar-password.php">¿Olvidaste tu contraseña?</a><br>
        <a href="registro.php">Crear una cuenta nueva</a>
      </div>

      <hr>

      <!-- Botón Google centrado -->
      <div class="form-group text-center">
        <a href="auth/google.php" class="btn btn-danger btn-block" style="max-width: 200px; margin: 0 auto;">
          <i class="fa fa-google"></i> Iniciar con Google
        </a>
      </div>

      <?php

        $login = new ControladorUsuarios();
        $login -> ctrIngresoUsuario();
        
      ?>

    </form>

  </div>

</div>

