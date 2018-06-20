<?php
if(!isset($safe)){
	exit();
}
?>
<script>
document.getElementById("title").innerHTML="Let's Encrypt";
</script>
<pre>
<form action="" method="post" id="hideOnClick">
<span style="font-weight: bold">Note: </span>Separate domains with commas, and for wildcard certs, use: "example.com, *.example.com"
Domain Name:    <input type="text" class="fancyInput" name="domain" required>
DNS Provider:   <select name="dns">
<option value="cloudflare">Cloudflare</option>
<option value="digitalocean">DigitalOcean</option>
<option value="dnsimple">DNSimple</option>
<option value="dnsmadeeasy">DNSMadeEasy</option>
<option value="dnspark">DNSPark</option>
<option value="easydns">EasyDNS</option>
<option value="namesilo">Namesilo</option>
<option value="ns1">NS1</option>
<option value="pointHQ">PointHQ</option>
<option value="rage4">Rage4</option>
<option value="vultr">Vultr</options>
</select>
<?php
if(is_dir("/var/www/.acme.sh")){
?>
<input type="checkbox" required> I understand this may overwrite any existing certs.
<?php
}
?>
Email/Username: <input type="text" class="fancyInput" name="email" required>
API Key:        <input type="password" class="fancyInput" name="key" required>
<input type="submit" class="fancyButton" value="Create SSL Cert" name="submit">
</form>
</pre>
<br>
<?php
	if(isset($_POST['submit'])){
		$domain=$_POST['domain'];
		$email=$_POST['email'];
		$key=$_POST['key'];
		$dns=$_POST['dns'];
	echo "Setting up Let's Encrypt wildcard for $domain on $dns DNS";
	pclose(popen("sudo $backend letsencrypt $domain $dns $email $key", "r"));
?>
<script>
document.getElementById("hideOnClick").style.display="none";
<?php
$type="letsencrypt";
include("$webroot/assets/refreshFrame.php");
?>
</script>
<?php
	}
?>
