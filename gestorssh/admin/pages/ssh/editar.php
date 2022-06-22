<?php

if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__)) {
  exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<?php
$dias_acesso = 0;

if (isset($_GET["id_ssh"])) {

  $diretorio = "../../admin/home.php?page=ssh/editar&id_ssh=" . $_GET['id_ssh'];


  $SQLUsuarioSSH = "select * from usuario_ssh WHERE id_usuario_ssh = '" . $_GET['id_ssh'] . "' ";
  $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
  $SQLUsuarioSSH->execute();


  $usuario_ssh = $SQLUsuarioSSH->fetch();

  if (($SQLUsuarioSSH->rowCount()) > 0) {

    $SQLServidor = "select * from servidor WHERE id_servidor = '" . $usuario_ssh['id_servidor'] . "'  ";
    $SQLServidor = $conn->prepare($SQLServidor);
    $SQLServidor->execute();
    $ssh_srv = $SQLServidor->fetch();

    //Calcula os dias restante
    $data_atual = date("Y-m-d ");
    $data_validade = $usuario_ssh['data_validade'];
    if ($data_validade > $data_atual) {
      $data1 = new DateTime($data_validade);
      $data2 = new DateTime($data_atual);
      $dias_acesso = 0;
      $diferenca = $data1->diff($data2);
      $ano = $diferenca->y * 364;
      $mes = $diferenca->m * 30;
      $dia = $diferenca->d;
      $dias_acesso = $ano + $mes + $dia;
    } else {
      $dias_acesso = 0;
    }

    $SQLUsuario = "select * from usuario WHERE id_usuario = '" . $usuario_ssh['id_usuario'] . "'  ";
    $SQLUsuario = $conn->prepare($SQLUsuario);
    $SQLUsuario->execute();


    $usuario_sistema = $SQLUsuario->fetch();

    $owner;

    if (!(($SQLUsuario->rowCount())  > 0)) {

      echo '<script type="text/javascript">';
      echo   'alert("Nao encontrado!");';
      echo  'window.location="home.php?page=ssh/contas";';
      echo '</script>';
      exit;
    }
  } else {
    echo '<script type="text/javascript">';
    echo   'alert("Nao encontrado!");';
    echo  'window.location="home.php?page=ssh/contas";';
    echo '</script>';
    exit;
  }
} else {
  echo '<script type="text/javascript">';
  echo   'alert("Preencha todos os campos!");';
  echo  'window.location="home.php?page=ssh/contas";';
  echo '</script>';
  exit;
}

if ($usuario_ssh['online'] >= 1) {
  $sts = 'success';
  $status = "<center><div class='alert alert-success col-6 col-md-6' role='alert'>
  <div class='alert-body d-center align-items-center'>
      <span>" . $usuario_ssh['online'] . " conexão de " . $usuario_ssh['acesso'] . "</span>
    </div>
  </div></center>";
} else {
  $sts = 'danger';
  $status = "<center><div class='alert alert-danger col-6 col-md-6' role='alert'>
  <div class='alert-body d-center align-items-center'>
      <span>OFFLINE</span>
    </div>
  </div></center>";
}



?>
<?php if ($usuario_ssh['status'] == 2) { ?>
  <center><div class='alert alert-danger col-12 col-md-12' role='alert'>
  <div class='alert-body d-center align-items-center'>
      <span>CONTA SUSPENSA</span>
    </div>
  </div></center>
<?php } ?>

<div class="row match-height">
  <div class="col-md-6">
    <div class="card card-transaction card border-<?php echo $sts; ?>">
      <div class="demo-spacing-1">
        <br>
        <?php echo $status; ?>
      </div>
      <div class="card-body">
      <ul class="list-group list-group-unbordered">
      <li class="list-group-item">
        <div class="transaction-item">
          <div class="d-flex">
            <div class="avatar bg-light-primary rounded float-start">
              <div class="avatar-content">
                <i data-feather='clock' class="avatar-icon font-medium-3"></i>
              </div>
            </div>
            <div class="my-auto">
              <h6 class="mb-0 text-primary">Vencimento</h6>
            </div>
          </div>
          <div class="fw-bolder text-warning"><?php echo $dias_acesso . " dia(s)"; ?></div>
        </div>
      </li>
      <li class="list-group-item">
        <div class="transaction-item">
          <div class="d-flex">
            <div class="avatar bg-light-primary rounded float-start">
              <div class="avatar-content">
                <i data-feather='server' class="avatar-icon font-medium-3"></i>
              </div>
            </div>
            <div class="my-auto">
              <h6 class="mb-0 text-primary">Servidor</h6>
            </div>
          </div>
          <div class="fw-bolder text-warning"><?php echo $ssh_srv['nome']; ?></div>
        </div>
      </li>
      <li class="list-group-item">
        <div class="transaction-item">
          <div class="d-flex">
            <div class="avatar bg-light-primary rounded float-start">
              <div class="avatar-content">
                <i data-feather='shield' class="avatar-icon font-medium-3"></i>
              </div>
            </div>
            <div class="my-auto">
              <h6 class="mb-0 text-primary">Login SSH</h6>
            </div>
          </div>
          <div class="fw-bolder text-warning"><?php echo $usuario_ssh['login']; ?></div>
        </div>
      </li>
      <li class="list-group-item">
        <div class="transaction-item">
          <div class="d-flex">
            <div class="avatar bg-light-primary rounded float-start">
              <div class="avatar-content">
                <i data-feather='users' class="avatar-icon font-medium-3"></i>
              </div>
            </div>
            <div class="my-auto">
              <h6 class="mb-0 text-primary">Dono</h6>
            </div>
          </div>
          <div class="fw-bolder"><a href="home.php?page=usuario/perfil&id_usuario=<?php echo $usuario_sistema['id_usuario']; ?>" class="pull-right"><?php echo $usuario_sistema['nome']; ?></a></div>
        </div>
      </li>
        <form role="form2" action="../pages/system/funcoes.conta.ssh.php" method="post" class="form-horizontal">
          <div class="box-footer">
            <input type="hidden" id="diretorio" name="diretorio" value="../../admin/home.php?page=ssh/contas">
            <input type="hidden" id="id_usuario_ssh" name="id_usuario_ssh" value="<?php echo $usuario_ssh['id_usuario_ssh']; ?>">
            <input type="hidden" id="owner" name="owner" value="<?php echo $accessKEY; ?>">
            <br>
            <ul class="list-group">
              <li class="list-group mb-1">
                <button type="submit" class="btn btn-danger" id="op" name="op" value="deletar">Deletar conta SSH</button>
              </li>
              <li class="list-group mb-1">
              <?php if ($usuario_ssh['status'] == 2) { ?>
                <button type="submit" class="btn btn-success" id="op" name="op" value="ususpender">Reativar conta</button>
              <?php } else { ?>
                <button type="submit" class="btn btn-warning" id="op" name="op" value="suspender">Suspender conta</button>
              <?php } ?>
              </li>
              <li class="list-group mb-1">
              <button type="submit" class="btn btn-primary" id="op" name="op" value="kill">Derrubar conta SSH</button>
              </li>
            </ul>
            
          </div>
        </form>
      </ul>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card card border-primary">
      <div class="card-body p-b-0">
        <h4 class="card-title"><i class="fa fa-edit"></i> Editar conta SSH</h4>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs customtab" role="tablist">
          <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#owner" role="tab" aria-selected="true"><i data-feather="users"></i>Alterar Dono</span></a> </li>
          <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#senha" role="tab" aria-selected="true"><i data-feather="key"></i> Senha</span></a> </li>
          <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#vencimento" role="tab" aria-selected="false"><i data-feather="clock"></i> Vencimento</span></a> </li>
          <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#acesso" role="tab" aria-selected="false"><i data-feather="smartphone"></i>Limite</span></a> </li>
          <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#migrar" role="tab" aria-selected="false"><i data-feather='repeat'></i>Migrar Conta</span></a> </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <div class="active tab-pane" id="owner">
            <div>
              <form role="owner" action="../pages/system/funcoes.conta.ssh.php" method="post" class="form-horizontal">
                <div class="col-md-12">
                  <select class="form-select" style="width: 100%;" name="n_owner" id="n_owner">
                    <option selected="selected" value="<?php echo $usuario_sistema['id_usuario']; ?>"><?php echo $usuario_sistema['login']; ?></option>
                    <?php
                    $owner = $usuario_sistema['id_usuario'];
                    $SQLUsuario = "SELECT * FROM usuario ";
                    $SQLUsuario = $conn->prepare($SQLUsuario);
                    $SQLUsuario->execute();
                    if (($SQLUsuario->rowCount()) > 0) {
                      // output data of each row
                      while ($row = $SQLUsuario->fetch()) {
                        if ($row['id_usuario'] != $usuario_sistema['id_usuario']) {
                    ?>
                          <option value="<?php echo $row['id_usuario']; ?>"><?php echo $row['login']; ?></option>
                    <?php }
                      }
                    }
                    ?>
                  </select>
                </div>
                <!-- /.box-body -->
                <div class="text-center">
                  <input type="hidden" id="op" name="op" value="owner">
                  <input type="hidden" id="diretorio" name="diretorio" value="<?php echo $diretorio; ?>">
                  <input type="hidden" id="id_usuario_ssh" name="id_usuario_ssh" value="<?php echo $usuario_ssh['id_usuario_ssh']; ?>">
                  <input type="hidden" id="owner" name="owner" value="<?php echo $accessKEY; ?>">
                  <br><a type="submit" class="btn btn-primary">Alterar Dono da conta SSH</a>
                </div>
                <!-- /.box-footer -->
              </form>
            </div>
          </div>
          <div class="tab-pane" id="senha">
            <div>
              <form role="senha" id="senha" name="senha" action="../pages/system/funcoes.conta.ssh.php" method="post" class="form-horizontal">
                <div class="box-body">
                  <div class="col-md-12">
                      <input required="required" type="text" class="form-control" id="senha_ssh" name="senha_ssh" placeholder="Digite a nova senha">
                    </div>
                    <input type="hidden" id="op" name="op" value="senha">
                    <input type="hidden" id="id_ssh" name="id_ssh" value="<?php echo $_GET["id_ssh"]; ?>">
                    <input type="hidden" id="diretorio" name="diretorio" value="<?php echo $diretorio; ?>">
                    <input type="hidden" id="id_servidor" name="id_servidor" value="<?php echo $ssh_srv['id_servidor']; ?>">
                    <input type="hidden" id="id_usuario_ssh" name="id_usuario_ssh" value="<?php echo $usuario_ssh['id_usuario_ssh']; ?>">
                    <input type="hidden" id="owner" name="owner" value="<?php echo $accessKEY; ?>">
                  </div>
                <div class="text-center">
                 <br><button type="submit" class="btn btn-primary">Alterar Senha</button><br>
                </div>
              </form>
            </div>
          </div>

          <div class="tab-pane" id="vencimento">
            <div class="box-header with-border">
              <form role="form2" action="../pages/system/funcoes.conta.ssh.php" method="post" class="form-horizontal">
                <div class="box-body">
                  <div class="col-md-12">
                      <input required="required" type="number" class="form-control" id="dias" name="dias" placeholder="Digite a quantidade dias de acesso" value="<?php echo $dias_acesso; ?>">
                    </div>
                    <input type="hidden" id="op" name="op" value="dias">
                    <input type="hidden" id="id_usuarioSSH" name="id_usuarioSSH" value="<?php echo $_GET["id_ssh"]; ?>">
                    <input type="hidden" id="diretorio" name="diretorio" value="<?php echo $diretorio; ?>">
                    <input type="hidden" id="owner" name="owner" value="<?php echo $accessKEY; ?>">
                  </div>
                  <div class="text-center">
                  <br><button type="submit" class="btn btn-primary">Alterar dias de acesso</button> </center><br>
                  </div>
              </form>
            </div>
          </div>

          <div class="tab-pane" id="acesso">
            <div>
              <div class="box-header with-border">
                <form role="form2" action="../pages/system/funcoes.conta.ssh.php" method="post" class="form-horizontal">
                  <div class="box-body">
                    <div class="col-md-12">
                        <input required="required" type="number" class="form-control" id="acesso" name="acesso" placeholder="Digite a quantidade de acesso" value="<?php echo $usuario_ssh['acesso']; ?>">
                      </div>
                      <input type="hidden" id="op" name="op" value="acesso">
                      <input type="hidden" id="diretorio" name="diretorio" value="<?php echo $diretorio; ?>">
                      <input type="hidden" id="id_usuario_ssh" name="id_usuario_ssh" value="<?php echo $usuario_ssh['id_usuario_ssh']; ?>">
                      <input type="hidden" id="sistema" name="sistema" value="<?php echo $owner; ?>">
                      <input type="hidden" id="owner" name="owner" value="<?php echo $accessKEY; ?>">
                  </div>
                  <div class="text-center">
                    <br><button type="submit" class="btn btn-primary">Alterar conexao simutanea</button><br>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="tab-pane" id="migrar">
            <div class="box-header with-border">
              <form role="migrar" action="../pages/system/funcoes.conta.ssh.php" method="post" class="form-horizontal">
                <div class="form-group mb-1">
                  <label>Servidor Atual</label>
                  <?php
                  $SQLServidor = "select * from servidor WHERE id_servidor = '" . $ssh_srv['id_servidor'] . "' ";
                  $SQLServidor = $conn->prepare($SQLServidor);
                  $SQLServidor->execute();
                  $servidor = $SQLServidor->fetch();
                  $SQLContasSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_servidor = '" . $ssh_srv['id_servidor'] . "'  ";
                  $SQLContasSSH = $conn->prepare($SQLContasSSH);
                  $SQLContasSSH->execute();
                  $SQLContasSSH = $SQLContasSSH->fetch();
                  $contas_ssh_criadas += $SQLContasSSH['quantidade'];
                  ?>
                  <input required="required" type="text" class="form-control" value=" <?php echo $ssh_srv['nome']; ?> - <?php echo $ssh_srv['ip_servidor']; ?> -  <?php echo $contas_ssh_criadas; ?> Conexões">
                </div>
                <div class="form-group">
                  <label>Selecione um servidor destino</label>
                  <select class="form-select" style="width: 100%;" name="id_new_servidor" id="id_new_servidor">
                    <?php
                    $SQLAcesso = "select * from servidor where id_servidor != '" . $ssh_srv['id_servidor'] . "' ";
                    $SQLAcesso = $conn->prepare($SQLAcesso);
                    $SQLAcesso->execute();
                    if (($SQLAcesso->rowCount()) > 0) {
                      // output data of each row
                      while ($row_srv = $SQLAcesso->fetch()) {
                        $contas_ssh_criadas = 0;
                        $SQLServidor = "select * from servidor WHERE id_servidor = '" . $row_srv['id_servidor'] . "' ";
                        $SQLServidor = $conn->prepare($SQLServidor);
                        $SQLServidor->execute();
                        $servidor = $SQLServidor->fetch();
                        $SQLContasSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_servidor = '" . $row_srv['id_servidor'] . "'  ";
                        $SQLContasSSH = $conn->prepare($SQLContasSSH);
                        $SQLContasSSH->execute();
                        $SQLContasSSH = $SQLContasSSH->fetch();
                        $contas_ssh_criadas += $SQLContasSSH['quantidade'];
                    ?>
                        <option value="<?php echo $row_srv['id_servidor']; ?>"> <?php echo $servidor['nome']; ?> - <?php echo $servidor['ip_servidor']; ?> - <?php echo $contas_ssh_criadas; ?> Conexões </option>
                    <?php }
                    }
                    ?>
                  </select>
                </div>
                <!-- /.box-body -->
                <div class="text-center">
                  <input type="hidden" id="op" name="op" value="migrar">

                  <input type="hidden" id="diretorio" name="diretorio" value="<?php echo $diretorio; ?>">

                  <input type="hidden" id="id_ssh" name="id_ssh" value="<?php echo $usuario_ssh['id_usuario_ssh']; ?>">

                  <input type="hidden" id="owner" name="owner" value="<?php echo $accessKEY; ?>">

                  <br><button type="submit" class="btn btn-primary">Mudar de Servidor</button><br>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>