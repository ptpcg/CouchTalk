CouchTalk
=========

PHP Class for talking to Couch DB

Usage
=========

<h3>Settings</h3>

<code style="padding: 10px;width:100%;[b]display:block;[/b]">
$settings = array(<br />
		'usr'=>'couch_db_user',<br />
		'pwd'=>'couch_db_passwd',<br />
		'host'=>'hostname_or_ip',<br />
		'port'=>'port',<br />
		'protocol'=>'http' //http or https <br />
);
</code>

<h3>Instantiate</h3>

<code style="padding: 10px;width:100%;[b]display:block;[/b]">
	$couch = new CouchTalk($settings);
</code>


<h3>Methods</h3>

<h4>DBs</h4>

<code style="padding: 10px;width:100%;[b]display:block;[/b]">
	<b>List All DBs</b><br />
	$couch->lsDBs();
</code><br /><br />
<code style="padding: 10px;width:100%;[b]display:block;[/b]">
	<b>Create New DB</b><br />
	$couch->mkDB("db_name");
</code><br /><br />
<code style="padding: 10px;width:100%;[b]display:block;[/b]">
	<b>Delete DB</b><br />
	$couch->rmDB("db_name");
</code><br /><br />
<code style="padding: 10px;width:100%;[b]display:block;[/b]">
	<b>Set DB</b><br />
	$couch->setDB("db_name");
</code><br /><br />
<code style="padding: 10px;width:100%;[b]display:block;[/b]">
	<b>List All Docs in DB</b><br />
	$couch->lsDB("db_name",true); //true includes docs
</code><br /><br />
<code style="padding: 10px;width:100%;[b]display:block;[/b]">
	<b>List All Changes in DB</b><br />
	$couch->logCatDB("db_name",true); //true includes docs
</code>

<h4>Docs</h4>

<code style="padding: 10px;width:100%;[b]display:block;[/b]">
	<b>Create Doc</b><br />
	$doc = array(<br />
	 		"name"=>"App Name",<br />
	 		"lang"=>"English",<br />
	 		"mods"=>array(1,2,3,4,5),<br />
	 		"stat"=>1<br />
	);<br />
	$couch->mkDoc("doc_name",$doc);
</code><br /><br />
<code style="padding: 10px;width:100%;[b]display:block;[/b]">
	<b>Get Doc</b><br />
	$ob->getDoc("doc_name");
</code><br /><br />
<code style="padding: 10px;width:100%;[b]display:block;[/b]">
	<b>Remove Doc</b><br />
	$ob->rmDoc("doc_name");
</code><br /><br />
<code style="padding: 10px;width:100%;[b]display:block;[/b]">
	<b>Update Doc</b><br />
	$upField = "stat";<br />
	$upData = 1;<br />
	$couch->updateDoc("new_app",null,$upField,$upData);
</code><br /><br />
<code style="padding: 10px;width:100%;[b]display:block;[/b]">
	<b>Overwrite Doc</b><br />
	$upField = "stat";<br />
	$upData = 1;<br />
	$rev = "revison_string_data";<br /
	$couch->updateDoc("new_app",$rev,$upField,$upData);
</code>	<br /><br />
<code style="padding: 10px;width:100%;[b]display:block;[/b]">
	<b>Update Doc (Multiple Fields)</b><br />
	$upFields = array("stat","lang","mods");<br />
	$upData = array("stat"=>1,"lang"=>"Deutsche","mods"=>array(1,2,5));<br />
	$couch->updateDoc("new_app",null,$upFields,$upData);
</code><br /><br />
<code style="padding: 10px;width:100%;[b]display:block;[/b]">
	<b>Ovewrite Doc (Multiple Fields)</b><br />
	$upFields = array("stat","lang","mods");<br />
	$upData = array("stat"=>1,"lang"=>"Deutsche","mods"=>array(1,2,5));<br />
	$rev = "revison_string_data";<br />	
	$couch->updateDoc("new_app",$rev,$upFields,$upData);
</code>	



ToDo
=========

-Add attachment support<br />
-Add view manipulation support<br />
-Add replication support<br />
-Clean up code<br />
