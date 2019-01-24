<ul>
	<p>
	Les composants iPuzzle sont la pierre angulaire du projet.
Il sont divisés en deux catégories : WinPieces côté client,
WebPieces côté serveur.
	</p>
	<p><b>1 - Les WinPieces.</b></p>
	Les WinPieces sont écrits en C#. Le choix du Framework .Net s'explique par
sa grande popularité et sa souplesse. Si l'on peut reprocher à .Net de ne
pas être multi-plate-forme comme Java, cette technologie est néanmoins plus
performante.</p> 
	<p>Vous pouvez avoir un apperçu du fonctionnement de iPuzzle en jetant un
oeil à la copie d'écran de l'application exemple.	
	</p>
	<p>
	Les WinPieces se composent de quelques dixaines de fonctions ordonnées en
	espaces de noms similaires à ceux d'origines dans le Framework .Net:
	<ul>
		<li>iPuzzle.WinPieces: Gestion de collections de controles, constantes, etc. 
		</li>
		<li>iPuzzle.WinPieces.Server: Connexion au serveur iPuzzle. 
		</li>
		<li>iPuzzle.WinPieces.Data: Accès aux données via DataSet. 
		</li>
		<li>iPuzzle.WinPieces.Forms: Controles graphiques : DataGrid, QueryText, etc. 
		</li>
		<li>iPuzzle.WinPieces.Web: Accès aux flux HTTP. 
		</li>
		<li>iPuzzle.WinPieces.Xml: Gestion simplifiée de flux XML. 
		</li>
	</ul> 
	</p>
	<p><b>2 - Les WebPieces.</b></p>
	<p>
	Les WebPieces sont inclus dans une bibliothèque de fonctions écrites en 
PHP 4. Elles s'intègrent dans un environnement web Apache/PHP/linux sous
la forme d'"includes" et permettent de développer aisément des applicaitons
web en tapant le moins possible de code HTML.</p>
	<p>
	Vous voyez actuellement les WebPieces en action sur ce site même si
tout n'est pas actif. Le composant le plus aboutit est la grille de données
que vous pouvez voir à la pages des news.</p>
<p> 
	Les WebPieces fournissent également :
	<ul>
		<li>grille d'images,</li>
		<li>liste de fichiers,</li>
		<li>liste de répertoires,</li>
		<li>menus dynamiques,</li>
		<li>présentation des menus par blocs,</li>
		<li>gestion de membres avec profil,</li>
		<li>gestion de newsletter,</li>
		<li>gestion d'agenda,</li>
		<li>bouton à la volée,</li>
		<li>etc.</li>
	</ul>
	</p>
	<p>Site utilisant les WebPieces : <a href="http://www.scuderia.fr" target="_new">www.scuderia.fr</a> 
	</p>
</ul>
