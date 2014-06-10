function carregarTelefones()
{
	dojo.xhrGet({
		'url':'http://localhost/bueno/default/index/index/cpf/' + dojo.byId('cpf').value,
		'form':dojo.byId('form1'),
		'load':function(dados){
				dojo.byId('telefones').innerHTML = dados;
			},
		'error':function()
		{
				dojo.byId('telefones').innerHTML = 'Ocorreu um erro';
		}
	});
}


dojo.ready(function(){
	dojo.connect(dojo.byId('btn'), 'click',carregarTelefones);
	
});