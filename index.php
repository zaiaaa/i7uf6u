<!DOCTYPE html>

<?php
	include("database.php");
	$conexao = conecta();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Free">
    <meta name="keywords" content="">
    <meta name="author" content="Gustavo Zaia, Moisés">
    <title>Document</title>
	
	<style>
		table, th, td {
			border: 1px solid #000000
		}
		
	</style>
</head>
<body>

	<?php 
		// Verificar se foi enviando dados via POST
		if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
			$id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
			$nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
			$sobrenome = (isset($_POST["sobrenome"]) && $_POST["sobrenome"] != null) ? $_POST["sobrenome"] : "";
			$email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";
		} else if (!isset($id)) {
			// Se não se não foi setado nenhum valor para variável $id
			$id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
			$nome = NULL;
			$sobrenome = NULL;
			$email = NULL;
		}
		if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "") {
			try {
				//$stmt = $conexao->prepare("INSERT INTO myguests (firstname, lastname, email) VALUES (?, ?, ?)");
				//esse bindParam é de achar o parametro e dar o valor p ele
				//no caso abaixo, pegamos a primeira ? e colocamos o valor de $nome nele
				
				if ($id != "") {
					$stmt = $conexao->prepare("UPDATE myguests SET firstname=?, lastname=?, email=? WHERE id = ?");
					$stmt->bindParam(4, $id);
				} else {
					$stmt = $conexao->prepare("INSERT INTO myguests (firstname, lastname, email) VALUES (?, ?, ?)");
				}

				$stmt->bindParam(1, $nome);
				$stmt->bindParam(2, $sobrenome);
				$stmt->bindParam(3, $email);
				 
				$stmt->execute();
				if ($stmt->rowCount() > 0) {
					echo "<h4>Dados cadastrados com sucesso!</h4>\n";
					$id = null;
					$nome = null;
					$sobrenome = null;
					$email = null;
				} else {
					echo "<h4>Erro ao tentar efetivar cadastro</h4>\n";
				}
			} catch (PDOException $erro) {
				echo "Erro: " . $erro->getMessage();
			}
		}
		if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
			try {
				$conexao = conecta();
				$stmt = $conexao->prepare("SELECT * FROM myguests WHERE id = ?");
				$stmt->bindParam(1, $id, PDO::PARAM_INT);
				$stmt->execute();
				$rs = $stmt->fetch(PDO::FETCH_OBJ);
				//o fetch object transforma a sua consulta num objeto, com atributos. ent com um $stmt->id pegamos o id dele facilmente
				$id = $rs->id;
				$nome = $rs->firstname;
				$sobrenome = $rs->lastname;
				$email = $rs->email;
			} catch (PDOException $erro) {
				echo "Erro: ".$erro->getMessage();
			}
		}
	
	?>

    <h2>Exemplo PDO</h2>
	<hr>
	//com esse ?act ele cria um metodo de req
	<form action="?act=save" method="POST" name="form1" >
		<input type="hidden" name="id"<?php
            // Preenche o id no campo id com um valor "value"
            if (isset($id) && $id != null || $id != "") {
                echo "value=\"{$id}\"";
            }
        ?>>
		
		Nome:
		<input type="text" name="nome"<?php
            // Preenche o nome no campo nome com um valor "value"
            if (isset($nome) && $nome != null || $nome != ""){
                echo "value=\"{$nome}\"";
            }
        ?>>
		
		Sobrenome:
		<input type="text" name="sobrenome"<?php
            // Preenche o nome no campo nome com um valor "value"
            if (isset($sobrenome) && $sobrenome != null || $sobrenome != ""){
                echo "value=\"{$sobrenome}\"";
            }
        ?>>
		
		E-mail:
		<input type="email" name="email"<?php
            // Preenche o email no campo email com um valor "value"
            if (isset($email) && $email != null || $email != ""){
                echo "value=\"{$email}\"";
            }
        ?>>
		
		<input type="submit" value="salvar">
		<input type="reset" value="Novo">
		<hr>
	</form>
	<table>
		<thead>
			<tr>
				<th>Id</th>
				<th>Nome </th>
				<th>Sobrenome</th>
				<th>Email</th>
				<th>Data Cad.</th>
				<th>Ações</th>
			<tr>
		</thead>
		<tbody>
	
		<?php 
			try {
				$conexao = conecta();
				$stmt = $conexao-> prepare("SELECT id, firstname, lastname, 
				email, reg_date FROM myguests");
				$stmt->execute();
				
				/*trazendo dados num vetor - Por FECTH_ASSOC
				while ($rs = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$data = new DateTime($rs['reg_date'],
						new DateTimeZone('America/Sao_Paulo'));
					echo "<p>ID: " . $rs['id'] . "<br>\n"
						. "Nome: " . $rs['firstname'] . "<br>\n"
						. "Sobrenome: " . $rs['lastname'] . "<br>\n"
						. "Email: " . $rs['email'] . "<br>\n"
						. "Data Cad.: " . $data ->format("d/m/y H:i:s") . "<br>\n"
						. "</p>\n";
				}
				
				//echo "<p>Conectado com sucesso!</p>";
				echo "<h2>Trazendo os Dados em Objeto</h2>";
				*/
				
				
				//trazendo os dados em objeto
				while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
					$data = new DateTime($rs->reg_date,
							new DateTimeZone('America/Sao_Paulo'));
						echo "<tr>\n
								<td>" . $rs->id . "</td>\n"
								. "<td>" . $rs->firstname . "</td>\n"
								. "<td>" . $rs->lastname . "</td>\n"
								. "<td>" . $rs->email . "</td>\n"
								. "<td>" . $data ->format("d/m/y H:i:s") . "</td>\n"
								. "<td><a href=\"?act=upd&id=" . $rs->id . "\">[Alterar]</a>"
								."&nbsp;&nbsp;&nbsp;"
								."<a href=\"?act=del&id=" . $rs->id . "\">[Excluir]</a></td>\n"
							. "</tr>\n";
				 }
				 
				 
				
				 
			} catch (Exception $e) {
				echo "<p>Erro no banco de dados:<br>" . $e->getMessage() . "</p>";
			}
		?>
		</tbody>
	</table>
</body>
</html>