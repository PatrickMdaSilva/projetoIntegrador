
          <h2>Cadastrar livro</h2>
            <div class="form-group">
              <label for="name">Nome do livro:</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome do livro" value="">
            </div>
            <div class="form-group">
              <label for="formation">Estante:</label>
              <select class="form-select" aria-label="Default select example" name="type" id="type">
                <option selected value=""></option>
                <option value="Romance">Romance</option>
                <option value="Comeida">Coméida</option>
                <option value="Tragedia">Tragédia</option>
                <option value="Fantasia">Fantasia</option>
                <option value="Acao">Ação</option>
                <option value="Quadrinho">Quadrinho</option>
                <option value="Didatico">Didático</option>
              </select>
            </div>
            <div class="form-group">
              <label for="name">Author:</label>
              <input type="text" class="form-control" id="author" name="author" placeholder="Digite o author do livro" value="">
            </div>
            <div class="form-group">
              <label for="name">Edição:</label>
              <input type="text" class="form-control" id="edition" name="edition" placeholder="Digite número da edição" value="">
            </div>
            <div class="form-group">
              <label for="name">Editora:</label>
              <input type="text" class="form-control" id="publish" name="publish" placeholder="Digite o nome da editora " value="">
            </div>
            <div class="form-group">
              <label for="name">Nome do doador:</label>
              <input type="text" class="form-control" id="donor" name="donor" placeholder="Digite seu nome" value="<?= $fullName ?>">
            </div>
            <div class="form-group">
              <label for="name">Contato do doador:</label>
              <input type="text" class="form-control" id="contact" name="contact" placeholder="Digite o número do celular" value="">
            </div>
            <input type="submit" class="btn card-btn" value="Cadastrar">
</form>