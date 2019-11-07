<?php
    include_once("share/header-standard.php");

    $username = $_SESSION['ulogin'];
    $password = $_SESSION['upaswd'];
    $user_id = $_SESSION['user_id'];
    $profile_id = $_SESSION['profile_id'];
    $email = $_SESSION['email'];
    $_SESSION['timestamp'] = time();

    $acesso   =    User::getInstance();
    $contato  = Contact::getInstance();
    $endereco = Address::getInstance();

    $acesso->setLogin($username);
    $acesso->setPassword($password);

    if(!$acesso->passwordCheck() )
        header("Location: login.php");

    $lista1 = $acesso->select("login='{$username}'");

    $lista1 = (object) $lista1[0];
    
    $name = $lista1->name;
    $email = $lista1->email;

    
    $lista2 = $contato->select("user_id={$lista1->id}");
    $lista2 = (object) $lista2[0];

    $lista = $endereco->select("id={$lista2->address_id}");
    $end_record = FALSE;
    if(count($lista) > 0){
        $lista3 = (object) $lista[0];
        $endereco->setId($lista3->id);
        $id = $lista3->id;
        $end_record = TRUE;
    }else{
        $id = 0;
    }

    $acesso->setSaveId($lista2->id);
    $contato->setSaveId($lista2->id);
    $endereco->setSaveId($lista2->id);

    $contato->setUserId($lista1->id);

    $acesso->setId($lista1->id);
    $contato->setId($lista2->id);

    $number_focus = 0;

?>

<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ial360&#176;</title>
    <meta name="description" content="Plataforma ial360 - Instituto Alpha Lumen">
    <meta name="author" content="">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="../publico/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="../publico/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="../publico/css/fontastic.css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="../publico/css/grasp_mobile_progress_circle-1.0.0.min.css">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="../publico/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="../publico/css/style_ial.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="../publico/css/custom.css">

    <!-- Favicon-->
    <link rel="apple-touch-icon" sizes="57x57" href="../publico/img/projeto/ico/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../publico/img/projeto/ico/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../publico/img/projeto/ico/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../publico/img/projeto/ico/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../publico/img/projeto/ico/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../publico/img/projeto/ico/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../publico/img/projeto/ico/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../publico/img/projeto/ico/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../publico/img/projeto/ico/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="../publico/img/projeto/ico/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../publico/img/projeto/ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../publico/img/projeto/ico/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../publico/img/projeto/ico/favicon-16x16.png">
    <link rel="manifest" href="../publico/img/projeto/ico/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="../publico/img/projeto/ico/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

</head>

<body>

<div  >

    <form method="post" action="" class="text-center form-validate">
        <div class="page login-page">
            <div class="container">

                <div class="form-outer d-flex align-items-center">
                    <div class="form-inner dashboard-counts" style = "width:100%" >

                        <div class="logo text-uppercase">
                            <img src="../publico/img/projeto/ial360-redo-30.png" alt="ial360" class="img-fluid pb-3" width="200" height="100">
                            <!--    <strong class="text-primary">Plataforma ial360&#176;</strong> -->
                        </div>
                        <h3 class="card-title text-uppercase text-center pb-3">Cadastro</h3> 
                        <?php
                            if( isset($_POST['salvar']) ) {

                                //print_r($_POST);

                                if( isset($_POST['inName']) ){
                                    $contato->setName(addslashes($_POST['inName']));
                                }

                                if( isset($_POST['inGender']) ){
                                    $contato->setGender($_POST['inGender']);
                                    $lista2->gender = $_POST['inGender'];
                                }

                                if( isset($_POST['inBirthdate']) ){
                                    $contato->setBirthdate($_POST['inBirthdate']);
                                    $lista2->birthdate = $_POST['inBirthdate'];
                                }
        
                                if( isset($_POST['inRG']) ){
                                    $contato->setRG($_POST['inRG']);
                                    $lista2->rg = $_POST['inRG'];
                                }
        
                                if( isset($_POST['inRGEmissor']) ){
                                    $contato->setRGEmissor($_POST['inRGEmissor']);
                                    $lista2->rg_emissor = $_POST['inRGEmissor'];
                                }
        
                                if( isset($_POST['inCPF']) ){
                                    $contato->setCPF($_POST['inCPF']);
                                    $lista2->cpf = $_POST['inCPF'];
                                }
        
                                if( isset($_POST['inPhone']) ){
                                    $contato->setPhone($_POST['inPhone']);
                                    $lista2->phone = $_POST['inPhone'];
                                }
        
                                if( isset($_POST['inMobile']) ){
                                    $contato->setMobile($_POST['inMobile']);
                                    $lista2->mobile = $_POST['inMobile'];
                                }

                                if( isset($_POST['inEmail']) ){
                                    $contato->setEmail($_POST['inEmail']);
                                    $lista2->email = $_POST['inEmail'];
                                }

                                $lista3 = ['postal_code'=>'', 'name'=>'', 'number'=>'', 'complement'=>'', 'neighborhood'=>'', 'city'=>'', 'state'=>'', 'country'=>'', ];
                                $lista3 = (object) $lista3;

                                if( isset($_POST['inPostalCode']) ){
                                    $endereco->setPostalCode($_POST['inPostalCode']);
                                    $lista3->postal_code = $_POST['inPostalCode'];
                                }else{
                                    $endereco->setPostalCode('');
                                    $lista3->postal_code = '';
                                }

                                if( isset($_POST['inAddress']) ){
                                    $endereco->setName($_POST['inAddress']);
                                    $lista3->name = $_POST['inAddress'];
                                }else{
                                    $endereco->setName('');
                                    $lista3->name = '';
                                }

                                if( isset($_POST['inNumber']) ){
                                    $endereco->setNumber($_POST['inNumber']);
                                    $lista3->number = $_POST['inNumber'];
                                }else{
                                    $endereco->setNumber('');
                                    $lista3->number = '';
                                }

                                if( isset($_POST['inComplement']) ){
                                        $endereco->setComplement($_POST['inComplement']);
                                        $lista3->complement = $_POST['inComplement'];
                                }else{
                                    $endereco->setComplement('');
                                    $lista3->complement = '';
                                }

                                if( isset($_POST['inNeighborhood']) ){
                                    $endereco->setNeighborhood($_POST['inNeighborhood']);
                                    $lista3->neighborhood = $_POST['inNeighborhood'];
                                }else{
                                    $endereco->setNeighborhood('');
                                    $lista3->neighborhood = '';
                                }

                                if( isset($_POST['inCity']) ){
                                    $endereco->setCity($_POST['inCity']);
                                    $lista3->city = $_POST['inCity'];
                                }else{
                                    $endereco->setCity('');
                                    $lista3->city = '';
                                }

                                if( isset($_POST['inStateCode']) ){
                                    $endereco->setState($_POST['inStateCode']);
                                    $lista3->state = $_POST['inStateCode'];
                                }else{
                                    $endereco->setState('');
                                    $lista3->state = '';
                                }

                                if( isset($_POST['inCountry']) ){
                                    $endereco->setCountry($_POST['inCountry']);
                                    $lista3->country = $_POST['inCountry'];
                                }else{
                                    $endereco->setCountry('');
                                    $lista3->country = '';
                                }

                                if(!$contato->cpfCheck($_POST['inCPF'])){
                                    echo '<div class="alert alert-danger alert-dismissible fade show text-left" role="alert">';
                                    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                                    echo "<p>CPF inválido! Por favor preencha com um número válido.</p>";
                                    echo '</div>';
                                }else{
                                    $resultado = $endereco->select("postal_code = '{$lista3->postal_code}' AND name='{$lista3->name}' AND neighborhood='{$lista3->neighborhood}' AND city='{$lista3->city}' AND state='{$lista3->state}' AND country='{$lista3->country}' ");

                                    if(count($resultado) > 0){
                                        $resultado = (object)$resultado[0];
                                        $id = $resultado->id;
                                    }else{
                                        $resultado = $endereco->insert();
                                        $id = $resultado->id;
                                    }

                                    $contato->setAddressId($id);
                                    $contato->update();
                                    $acesso->mustContactUpdateOff();

                                    $subject = "Cadastro de Responsável - Processo Seletivo - ALPHA LUMEN";
                                    $message = "Você finalizou o cadastro de pai/responsável no processo seletivo.";
                                    EnviaEmail($name, $email, $subject, $message);

                                    header("Location: index.php");
                                }

                                $end_record = TRUE;
                                unset($_POST['salvar']);
                            }


                            if( isset($_POST['searchCEP']) ){

                                $lista = $endereco->searchPostalCode($_POST['inCEP']);
                                $lista3 = (object) $lista[0];
                                $end_record = TRUE;
                                $number_focus = 1;

                                unset($_POST['inCEP']);
                                unset($_POST['searchCEP']);
                            }

                        ?>

                        <hr class="my-2">
                        <div class="row text-left" id="div_view">

                            <h5 class="font-weight-bold col-12 mb-2">Endereço</h5>

                            <?php

                            ?>
                            <div class=" form-group col-sm-6 ">
                                <div class="input-group mb-2">
                                    <label class="form-control-label col-12 pl-0 ">CEP</label>
                                    <input name="inPostalCode" type="text" data-mask="99999-999" class="custom-select custom-select-sm " placeholder="" data-msg="Número do CEP" aria-label="Default" aria-describedby="basic-addon2"  value="<?php if($end_record) echo $lista3->postal_code; ?>" required readonly>
                                    <div class="input-group-append">
                                        <!--<button class="btn btn-sm btn-success" name="buscarCEP" type="submit" data-toggle="tooltip" data-placement="top" title="Clique para encontrar um logradouro usando seu CEP"><i class="fa fa-search" aria-hidden="true"></i></button>-->
                                        <span title="Pesquisar CEP para encontrar um logradouro" data-toggle="tooltip" data-placement="top"><button type="button" class="btn btn-sm btn-info " aria-hidden="true" data-toggle="modal" data-target="#cepModal" ><i class="fa fa-search" aria-hidden="true"></i> Pesquisar</button></span>
                                    </div>
                                </div>
                            </div>

                            <div class=" form-group col-sm-12 ">
                                <label class="form-control-label col-12 pl-0 ">Endereço</label>
                                <input name="inAddress" type="text" placeholder="" data-msg="Nome do logradouro" class="form-control form-control-sm " aria-label="Default" style="text-transform:uppercase" value="<?php if($end_record) echo $lista3->name; ?>" required >
                            </div>

                            <div class=" form-group col-sm-3 ">
                                <label class="form-control-label col-12 pl-0 ">Número</label>
                                <input name="inNumber" type="text" placeholder="" data-msg="Número" class="form-control form-control-sm " aria-label="Default" value="<?php if($end_record) echo $lista3->number; ?>" <?php if($number_focus == 1) echo ' autofocus ';?> required>
                            </div>

                            <div class=" form-group col-sm-6 ">
                                <label class="form-control-label col-12 pl-0 ">Complemento</label>
                                <input name="inComplement" type="text" placeholder="Complemento (EX. APTO 71)" class="form-control form-control-sm " aria-label="Default" style="text-transform:uppercase" value="<?php if($end_record) echo $lista3->complement; ?>">
                            </div>

                            <div class=" form-group col-sm-8 ">
                                <label class="form-control-label col-12 pl-0 ">Bairro</label>
                                <input name="inNeighborhood" type="text" placeholder="" data-msg="Bairro" class="form-control form-control-sm " aria-label="Default" style="text-transform:uppercase" value="<?php if($end_record) echo $lista3->neighborhood;?>" required >
                            </div>

                            <div class=" form-group col-sm-8 ">
                                <label class="form-control-label col-12 pl-0 ">Cidade</label>
                                <input name="inCity" type="text" placeholder="" data-msg="Informe a Cidade" class="form-control form-control-sm " aria-label="Default" style="text-transform:uppercase" value="<?php if($end_record) echo $lista3->city;?>" required >
                            </div>

                            <div class=" form-group col-sm-4 ">
                                <label class="form-control-label col-12 pl-0 ">Estado</label>
                                <select name="inStateCode" class="form-control form-control-sm " data-msg="Escolha o Estado" aria-label="Default" required >
                                    <option value=''></option>
                                    <option value='AC' <?php if($end_record) if($lista3->state == 'AC') echo 'selected'; ?> >ACRE</option>
                                    <option value='AL' <?php if($end_record) if($lista3->state == 'AL') echo 'selected'; ?> >ALAGOAS</option>
                                    <option value='AM' <?php if($end_record) if($lista3->state == 'AM') echo 'selected'; ?> >AMAZONAS</option>
                                    <option value='AP' <?php if($end_record) if($lista3->state == 'AP') echo 'selected'; ?> >AMAPÁ</option>
                                    <option value='BA' <?php if($end_record) if($lista3->state == 'BA') echo 'selected'; ?> >BAHIA</option>
                                    <option value='CE' <?php if($end_record) if($lista3->state == 'CE') echo 'selected'; ?> >CEARÁ</option>
                                    <option value='DF' <?php if($end_record) if($lista3->state == 'DF') echo 'selected'; ?> >DISTRITO FEDERAL</option>
                                    <option value='ES' <?php if($end_record) if($lista3->state == 'ES') echo 'selected'; ?> >ESPÍRITO SANTO</option>
                                    <option value='GO' <?php if($end_record) if($lista3->state == 'GO') echo 'selected'; ?> >GOIÁS</option>
                                    <option value='MA' <?php if($end_record) if($lista3->state == 'MA') echo 'selected'; ?> >MARANHÃO</option>
                                    <option value='MG' <?php if($end_record) if($lista3->state == 'MG') echo 'selected'; ?> >MINAS GERAIS</option>
                                    <option value='MS' <?php if($end_record) if($lista3->state == 'MS') echo 'selected'; ?> >MATO GROSSO DO SUL</option>
                                    <option value='MT' <?php if($end_record) if($lista3->state == 'MT') echo 'selected'; ?> >MATO GROSSO</option>
                                    <option value='PA' <?php if($end_record) if($lista3->state == 'PA') echo 'selected'; ?> >PARÁ</option>
                                    <option value='PB' <?php if($end_record) if($lista3->state == 'PB') echo 'selected'; ?> >PARAIBA</option>
                                    <option value='PE' <?php if($end_record) if($lista3->state == 'PE') echo 'selected'; ?> >PERNAMBUCO</option>
                                    <option value='PI' <?php if($end_record) if($lista3->state == 'PI') echo 'selected'; ?> >PIAUÍ</option>
                                    <option value='PR' <?php if($end_record) if($lista3->state == 'PR') echo 'selected'; ?> >PARANÁ</option>
                                    <option value='RJ' <?php if($end_record) if($lista3->state == 'RJ') echo 'selected'; ?> >RIO DE JANEIRO</option>
                                    <option value='RN' <?php if($end_record) if($lista3->state == 'RN') echo 'selected'; ?> >RIO GRANDE DO NORTE</option>
                                    <option value='RO' <?php if($end_record) if($lista3->state == 'RO') echo 'selected'; ?> >RONDÔNIA</option>
                                    <option value='RR' <?php if($end_record) if($lista3->state == 'RR') echo 'selected'; ?> >RORAIMA</option>
                                    <option value='RS' <?php if($end_record) if($lista3->state == 'RS') echo 'selected'; ?> >RIO GRANDE DO SUL</option>
                                    <option value='SC' <?php if($end_record) if($lista3->state == 'SC') echo 'selected'; ?> >SANTA CATARINA</option>
                                    <option value='SE' <?php if($end_record) if($lista3->state == 'SE') echo 'selected'; ?> >SERGIPE</option>
                                    <option value='SP' <?php if($end_record) if($lista3->state == 'SP') echo 'selected'; ?> >SÃO PAULO</option>
                                    <option value='TO' <?php if($end_record) if($lista3->state == 'TO') echo 'selected'; ?> >TOCANTINS</option>
                                    <option value='NA' <?php if($end_record) if($lista3->state == 'NA') echo 'selected'; ?> >OUTRO</option>
                                </select>
                            </div>

                            <div class=" form-group col-sm-8 ">
                                <label class="form-control-label col-12 pl-0 ">País</label>
                                <input name="inCountry" type="text" placeholder="" data-msg="Informe o País" class="form-control form-control-sm " aria-label="Default" style="text-transform:uppercase" value="<?php if($end_record) echo $lista3->country;?>" required >
                            </div>

                        </div>

                        <hr class="my-2">


                        <div class="row text-left">

                            <h5 class="font-weight-bold col-12 mb-2">Dados Cadastrais</h5>

                            <div class="form-group col-md-12 ">
                                <label class="form-control-label">Nome</label>
                                <input name="inName" type="text" placeholder="" data-msg="Nome completo" class="form-control form-control-sm " value="<?php echo $lista2->name;?>" required >
                            </div>

                            <div class="form-group col-md-4 ">
                                <label class="form-control-label">Sexo</label>
                                <select name="inGender" class="form-control form-control-sm " data-msg="Selecione o sexo" required>
                                    <option></option>
                                    <option value='F' <?php if($lista2->gender == 'F') echo 'selected'; ?>>Feminino</option>
                                    <option value='M' <?php if($lista2->gender == 'M') echo 'selected'; ?>>Masculino</option>
                                </select>
                            </div>

                            <div class="form-group col-md-5">
                                <label class="form-control-label">Data de Nascimento</label>
                                <input name="inBirthdate" type="date" placeholder="" data-msg="Data de nascimento" class="form-control form-control-sm " value="<?php echo $lista2->birthdate;?>" required >
                            </div>

                            <div class="form-group col-md-4">
                                <label class="form-control-label">RG</label>
                                <input name="inRG" type="text" placeholder="99.999.999-9" data-msg="Número do RG" class="form-control form-control-sm " value="<?php echo $lista2->rg;?>" required >
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-control-label">RG Emissor</label>
                                <input name="inRGEmissor" type="text" placeholder="Exemplo: SSP/SP" data-msg="Emissor do RG" class="form-control form-control-sm " value="<?php echo $lista2->rg_emissor;?>" required >
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-control-label">CPF</label>
                                <input name="inCPF" type="text" data-mask="999.999.999-99" placeholder="999.999.999-99" data-msg="Número do CPF" class="form-control form-control-sm " value="<?php echo $lista2->cpf;?>" required >
                            </div>

                            <div class="form-group col-md-4">
                                <label class="form-control-label">Telefone</label>
                                <input name="inPhone" type="text" data-mask="(99) 9999-9999" placeholder="" data-msg="Número de telefone fixo" class="form-control form-control-sm" value="<?php echo $lista2->phone;?>" >
                            </div>

                            <div class="form-group col-md-4">
                                <label class="form-control-label">Celular</label>
                                <input name="inMobile" type="text" data-mask="(99) 9 9999-9999" placeholder="(99) 9 9999-9999" data-msg="Número de celular" class="form-control form-control-sm " value="<?php echo $lista2->mobile;?>" required >
                            </div>

                            <div class="form-group col-md-12">
                                <label class="form-control-label">Email</label>
                                <input name="inEmail" type="email" placeholder="email@email.com" data-msg="Endereço de e-mail" class="form-control form-control-sm " value="<?php echo $lista2->email;?>" required >
                            </div>

                        </div>

                        <hr class="my-2">


                        <div class="row text-center">
                            <div class="col-md-12 ">
                                <button class="btn btn-success text-center" name="salvar" type="submit">Salvar</button>
                            </div>
                        </div>


                    </div>
                    <div class="copyrights text-center">
                        <p>&copy; 2019 - Instituto Alpha Lumen</p>
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>


 <!-- Modal Adicionar Faixa -->
 <div  class="modal fade text-left" id="cepModal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document" >
      <div class="modal-content">

         <form class="form form-validate"  method="post" action="#div_view">

            <div class="modal-header">
               <h4 class="modal-title">Pesquisar Endereço</h4>
               <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>

            <div class="modal-body">
               <div class="row">

                   <div class=" form-group col-sm-8 offset-sm-2">
                        <div class="input-group mb-2">
                            <label class="form-control-label col-12 pl-0 ">CEP</label>
                            <input name="inCEP" type="text" data-mask="99999-999" class="custom-select custom-select-sm " placeholder="" data-msg="Número do CEP" aria-label="Default" aria-describedby="basic-addon2"  value="" required>
                        </div>
                    </div>

               </div>
            </div>

            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
               <button name="searchCEP" type="submit" class="btn btn-primary ml-3 md-3" value="pesquisar" ><i class="fa fa-check" aria-hidden="true"></i> Pesquisar</button>
            </div>

         </form>
      </div>
   </div>
</div>



    <!-- JavaScript files-->
    <script src="../publico/vendor/jquery/jquery.min.js"></script>
    <script src="../publico/vendor/popper.js/umd/popper.min.js"> </script>
    <script src="../publico/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../publico/js/grasp_mobile_progress_circle-1.0.0.min.js"></script>
    <script src="../publico/vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="../publico/vendor/chart.js/Chart.min.js"></script>
    <script src="../publico/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="../publico/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- Jasny Bootstrap - Input Masks-->
    <script src="https://d19m59y37dris4.cloudfront.net/dashboard-premium/1-4-4/vendor/jasny-bootstrap/js/jasny-bootstrap.min.js"> </script>
    <!-- Main File-->
    <script src="../publico/js/front.js"></script>
 

</body>
</html>