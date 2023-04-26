<?
$errors = [];
$data = [];
$data['message'] = "Teste ok!";
$data['POST'] = @$_POST;
$data['GET'] = @$_GET;
if(!empty($errors)){
    $data['success'] = false;
    $data['message'] = "<span style=\"color:#EE3333;\"><i class=\"fa-solid fa-triangle-exclamation\"></i> ALGO DEU ERRADO: <br>Contate o desenvolvedor. <br>".str_replace("\n", "<br>", $errors)."</span>";
    $data['errors'] = $errors;
}else{
    $success = "success!";
    $data['success'] = $success;
    $data['message'] = "<span style=\"color:#33AAAA;\"><i class=\"fa-solid fa-circle-check\"></i> ".str_replace("\n", "<br>", $success)."</span>";
    $data['errors'] = false;
}
echo json_encode($data);
exit();
?>