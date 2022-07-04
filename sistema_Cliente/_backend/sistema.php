<?php

try{
    $con = new PDO('mysql:host=localhost;dbname=Sistema', 'root', '');
}
catch (PDOException $ex){
    echo 'Erro: '.$ex->getMessage();
}

if(isset($_POST['origem'])){

    if($_POST['origem'] == 'listaCliente'){

        $sql = $con->prepare('SELECT * FROM Clientes');
        $sql->execute();

        $totalC = $sql->rowCount();

        $sql = $con->prepare('SELECT * FROM Clientes LIMIT '.$_POST['pag'].', '.$_POST['qtd'].'');
        $sql->execute();

        while($row = $sql->fetch(PDO::FETCH_OBJ)){
            echo '<tr> <td class="nome">'.$row->nomeCliente.'</td><td class="data">'.$row->nascimento.'</td><td class="cpf">'.$row->cpf.'</td><td class="cel">'.$row->celular.'</td><td class="email">'.$row->email.'</td><td class="obs">'.$row->observacao.'</td> <td><button class="btn btn-warning" type="button" onclick="editar('.$row->idCliente.')">Editar</button> <button class="btn btn-danger" type="button" onclick="deletar('.$row->idCliente.')">Deletar</button></td> </tr>';
        }

        echo '<input type="hidden" id="totalCliente" value="'.$totalC.'">';

    }

    if($_POST['origem'] == 'filtrarCliente'){

        $sql = $con->prepare('SELECT * FROM Clientes');
        $sql->execute();

        $totalC = $sql->rowCount();

        $sql = $con->prepare('SELECT * FROM Clientes WHERE nomeCliente LIKE ? OR email LIKE ? LIMIT '.$_POST['pag'].', '.$_POST['qtd'].'');
        $sql->bindValue(1,$_POST['filtro']);
        $sql->bindValue(2,$_POST['filtro']);
        $sql->execute();

        while($row = $sql->fetch(PDO::FETCH_OBJ)){
            echo '<tr> <td class="nome">'.$row->nomeCliente.'</td><td class="data">'.$row->nascimento.'</td><td class="cpf">'.$row->cpf.'</td><td class="cel">'.$row->celular.'</td><td class="email">'.$row->email.'</td><td class="obs">'.$row->observacao.'</td> <td><button class="btn btn-warning" type="button" onclick="editar('.$row->idCliente.')">Editar</button> <button class="btn btn-danger" type="button" onclick="deletar('.$row->idCliente.')">Deletar</button></td> </tr>';
        }

        echo '<input type="hidden" id="totalCliente" value="'.$totalC.'">';

    }

    if($_POST['origem'] == 'cadastrarCliente'){

        $sql = $con->prepare('INSERT INTO Clientes(nomeCliente, nascimento, cpf, celular, email, observacao) VALUES(?, ?, ?, ?, ?, ?)');
        $sql->bindValue(1,$_POST['nome']);
        $sql->bindValue(2,$_POST['nascimento']);
        $sql->bindValue(3,$_POST['cpf']);
        $sql->bindValue(4,$_POST['celular']);
        $sql->bindValue(5,$_POST['email']);
        $sql->bindValue(6,$_POST['observacao']);

        if($sql->execute()){
            echo 'Cadastrado';
        }else{
            echo 'Erro';
        }
        
    }

    if($_POST['origem'] == 'deletarCliente'){

        $sql = $con->prepare('DELETE FROM Clientes WHERE idCliente = ?');
        $sql->bindValue(1,$_POST['idCliente']);

        if($sql->execute()){
            echo 'Deletado';
        }else{
            echo 'Erro';
        }
        
    }

    if($_POST['origem'] == 'cliente'){

        $sql = $con->prepare('SELECT * FROM Clientes WHERE idCliente = ?');
        $sql->bindValue(1,$_POST['idCliente']);

        if($sql->execute()){
            while($row = $sql->fetch(PDO::FETCH_OBJ)){

                echo '<form class="row" id="formEdita">
                <input type="hidden" name="origem" value="editarCliente">
                <input type="hidden" name="id" value="'.$_POST['idCliente'].'">
        
                <div class="col-12 col-sm-6">
                    <label>Nome*</label>
                    <input type="text" name="nome" id="nomeEdit" value="'.$row->nomeCliente.'">
                </div>
                <div class="col-12 col-sm-6">
                    <label>Data de Nascimento*</label>
                    <input type="date" name="nascimento" id="nascimentoEdit" value="'.$row->nascimento.'">
                </div>
                <div class="col-12 col-sm-4">
                    <label>CPF*</label>
                    <input type="text" name="cpf" id="cpfEdit" onkeyup="mascaraCpf(this);" maxlength="14" value="'.$row->cpf.'">
                </div>
                <div class="col-12 col-sm-3">
                    <label>Celular*</label>
                    <input type="text" name="celular" id="celularEdit" onkeyup="mascaraTel(this);" maxlength="15" value="'.$row->celular.'">
                </div>
                <div class="col-12 col-sm-5">
                    <label>Email*</label>
                    <input type="email" name="email" id="emailEdit" value="'.$row->email.'">
                </div>
                <div class="col-12">
                    <label>Observação</label>
                    <textarea name="observacao" id="observacaoEdit" maxlength="300" value="'.$row->observacao.'"></textarea>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="button" id="btnEdita" onclick="editarCliente()">Editar</button>
                </div>
        
                </form>';
            }

        }else{
            echo 'Erro';
        }
        
    }

    if($_POST['origem'] == 'editarCliente'){

        $sql = $con->prepare('UPDATE Clientes SET nomeCliente = ?, nascimento = ?, cpf = ?, celular = ?, email = ?, observacao = ? WHERE idCliente = ?');
        $sql->bindValue(1,$_POST['nome']);
        $sql->bindValue(2,$_POST['nascimento']);
        $sql->bindValue(3,$_POST['cpf']);
        $sql->bindValue(4,$_POST['celular']);
        $sql->bindValue(5,$_POST['email']);
        $sql->bindValue(6,$_POST['observacao']);
        $sql->bindValue(7,$_POST['id']);

        if($sql->execute()){
            echo 'Editado';
        }else{
            echo 'Erro';
        }
        
    }

}

?>