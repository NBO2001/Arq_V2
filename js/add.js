var cont = 1;

now = new Date;
var ano = now.getFullYear();

function novocampo(){
if (cont <=20) {
var origem = document.getElementById("campoOriegem");
var novocp = document.createElement("div");

novocp.setAttribute("id", "controle"+cont);

origem.appendChild(novocp);

	document.getElementById("controle"+cont).innerHTML =
	"<input type='file' accept='application/pdf' name='pdf[]' required/>&nbsp;&nbsp;&nbsp;&nbsp;"
	+"&nbsp;&nbsp;<input id='revbutton' type='button' onClick='removecamp("+cont+")' value='X'>&nbsp;&nbsp;<br><br>"
	+"<label>Tipo de documento:</label>&nbsp;&nbsp;"
	+"<select name='sele[]'>"
	+"<option>FICHA CADASTRAL</option>"
	+"<option>PROCESSO</option>"
	+"<option>REQUERIMENTO</option>"
	+"<option>TERMO DE COMPROMISSO DE ESTÁGIO (TCE)</option>"
	+"<option>HISTÓRICO ESCOLAR</option>"
	+"<option>FICHA</option>"
	+"<option>OFÍCIO</option>"
	+"<option>FORMULÁRIO DE CORREÇÃO DE NOTAS E FALTAS</option>"
	+"<option>MEMORANDO</option>"
	+"<option>RESOLUÇÃO</option>"
	+"<option>PORTARIA</option>"
	+"<option>PARECE</option>"
	+"<option>FORMULÁRIO DE CORREÇÃO DE HISTÓRICO</option>"
	+"</select><br><br>"
	+"<label>Classificação do documento:&nbsp;</label>"
  +"<input  id='clone"+cont+"' type='text' name='class[]' placeholder='Pesquisar Classificação do documento' required><br><br>"
	+"<label>Descrição: &nbsp;&nbsp;&nbsp;&nbsp;</label>"
  +"<input type='text' name='complemento[]' placeholder='Decreva o assunto do documento'><br><br>"
	+"<label>Ano do documento:&nbsp;</label>"
	+"<input id='ano' name='ano[]' value='"+ano+"' type='number' min='1900' max='"+ano+"' required>"
	;

	cont++;
}else{
	alert ("Somente 20 compos são possiveis!!");
}

}
function removecamp(id){
	var origem = document.getElementById("campoOriegem");
	var campofilho = document.getElementById("controle"+id);
	origem.removeChild(campofilho);
}
$(function () {
		$("#assunto").autocomplete({
				source: 'proc_pesq_msg.php'
		});
});

