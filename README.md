# Website das Funções ZZ

Aqui estão os fontes do site das Funções ZZ, no ar em <http://funcoeszz.net>.

Correções e sugestões são muito bem-vindas, mande seus [Pull Requests](https://help.github.com/articles/using-pull-requests)!



# Instruções

Os arquivos-fonte da maioria das páginas do site estão no formato do [txt2tags](http://txt2tags.org), que é o programa que converte estes fontes para HTML.

	txt2tags index.t2t    # Gera o arquivo index.html

Para fazer correções no conteúdo do site, basta editar os arquivos com a extensão `t2t`. O formato é basicamente texto puro, similar ao Markdown. Você pode inclusive editar diretamente aqui pelo site do GitHub, usando o botão `Edit`.

> Não edite os arquivos HTML, pois eles são gerados à partir dos arquivos txt2tags de mesmo nome, então sua edição será perdida.

Há alguns cabeçalhos especiais no topo dos arquivos, iniciados por `%!`. Basta ignorá-los.

No meio do texto, linhas iniciadas por `%` são comentários e não aparecem no HTML.

Os arquivos iniciados com underline `_` são especiais:

- Arquivos de configuração:
    - _config.sh
    - _config.t2t
    - _config-theme.t2t
- Pedaços do site:
    - _analytics.html
    - _comments.html
    - _footer.t2t
    - _menu.t2t
    - _site.css

Infelizmente [ainda não podemos](https://github.com/funcoeszz/website/issues/1) usar o GitHub para hospedar o site, então a atualização dele no servidor é manual, feita pelo Aurelio com o `rsync`.



# Scripts de atualização

Para converter para HTML todos os arquivos do site de uma só vez:

	$ ./2html.sh
	txt2tags wrote acessivel.html
	txt2tags wrote anuncio-13.2.html
	txt2tags wrote aovivo.html
	txt2tags wrote changelog.html
	txt2tags wrote donate.html
	txt2tags wrote download.html
	txt2tags wrote faq.html
	txt2tags wrote hist.html
	txt2tags wrote index.html
	txt2tags wrote list.html
	txt2tags wrote logo.html
	txt2tags wrote man.html
	txt2tags wrote my.html
	txt2tags wrote premio.html
	txt2tags wrote thanks.html
	$

Para atualizar [a tabela](http://funcoeszz.net/list.html) com a lista completa de funções, use:

	$ ./_list.t2t.sh       # Atualiza o arquivo _list.t2t
	$ txt2tags list.t2t    # Atualiza a versão HTML

Para atualizar [a página de manual](http://funcoeszz.net/man.html), primeiro é preciso executar um script do [repositório principal](https://github.com/funcoeszz/funcoeszz):

	$ ../funcoeszz/manpage/genman
	Generating funcoeszz script...
	zzajuda
	zzalfabeto
	zzansi2html
	zzarrumacidade
	...

Agora sim, basta regerar a versão HTML:

	$ txt2tags man.t2t

Por fim, para atualizar [as descrições](https://github.com/funcoeszz/website/blob/master/a-la-carte/description.php) das funções, usadas pelo [ZZ à la carte](http://funcoeszz.net/a-la-carte/):

	$ ./a-la-carte/description.php.sh

E aqui vai a versão tudo-em-um, pronta para copiar e colar no terminal:

	./_list.t2t.sh
	./a-la-carte/description.php.sh
	../funcoeszz/manpage/genman 2>/dev/null
	./2html.sh
