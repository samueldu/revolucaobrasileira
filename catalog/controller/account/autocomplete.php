<?
class ControllerAccountAutocomplete extends Controller {	
	public function index() {
$val = "[";
foreach($this->session->data['amigos']->data as $key)
{
$nome = $key->name; 

$urlImg = "https:\/\/graph.facebook.com\/".$key->id."\/picture";

//$urlImg = "https:\/\/fbcdn-profile-a.akamaihd.net\/hprofile-ak-snc4\/260607_513979628_650958_q.jpg";

//$urlImg = "catalog\/view\/theme\/bongspipes\/image\/share_face.gif";

$val .= '['.$key->id.',"'.$nome.'",null,"<img src=\"'.$urlImg.'\" \/> '.$nome.'"],';
//$val .= "[".$key->id.",\"".$nome."\",\"".$nome."\"],";

}
$val = Substr($val,0,-1);
$val .="]";
print $val;
	
//	echo '[[0,"AIAI",null,"<img src=\"images\/aiai.jpg\" \/> AIAI"],[1,"Abraham Lincoln",null,"<img src=\"images\/abrahamlincoln.jpg\" \/> Abraham Lincoln"],[2,"Adolf Hitler",null,"<img src=\"images\/adolfhitler.jpg\" \/> Adolf Hitler"],[3,"Agent Smith",null,"<img src=\"images\/agentsmith.jpg\" \/> Agent Smith"],[4,"Agnus",null,"<img src=\"images\/agnus.png\" \/> Agnus"],[5,"Akira Shoji",null,"<img src=\"images\/akirashoji.jpg\" \/> Akira Shoji"],[6,"Akuma",null,"<img src=\"images\/akuma.jpg\" \/> Akuma"],[7,"Alex",null,"<img src=\"images\/alex.jpg\" \/> Alex"],[8,"Antoinetta Marie",null,"<img src=\"images\/antoinettamarie.jpg\" \/> Antoinetta Marie"],[9,"Baal",null,"<img src=\"images\/baal.jpg\" \/> Baal"],[10,"Baby Luigi",null,"<img src=\"images\/babyluigi.jpg\" \/> Baby Luigi"],[11,"Backpack",null,"<img src=\"images\/backpack.jpg\" \/> Backpack"],[12,"Baralai",null,"<img src=\"images\/baralai.jpg\" \/> Baralai"],[13,"Bardock",null,"<img src=\"images\/bardock.jpg\" \/> Bardock"],[14,"Baron Mordo",null,"<img src=\"images\/baronmordo.png\" \/> Baron Mordo"],[15,"Barthello",null,"<img src=\"images\/barthello.jpg\" \/> Barthello"],[16,"Blanka",null,"<img src=\"images\/blanka.jpg\" \/> Blanka"],[17,"Bloody Brad",null,"<img src=\"images\/bloodybrad.jpg\" \/> Bloody Brad"],[18,"Cagnazo",null,"<img src=\"images\/cagnazo.jpg\" \/> Cagnazo"],[19,"Calonord",null,"<img src=\"images\/calonord.png\" \/> Calonord"],[20,"Calypso",null,"<img src=\"images\/calypso.jpg\" \/> Calypso"],[21,"Cao Cao",null,"<img src=\"images\/caocao.jpg\" \/> Cao Cao"],[22,"Captain America",null,"<img src=\"images\/captainamerica.jpg\" \/> Captain America"],[23,"Chang",null,"<img src=\"images\/chang.jpg\" \/> Chang"],[24,"Cheato",null,"<img src=\"images\/cheato.jpg\" \/> Cheato"],[25,"Cheshire Cat",null,"<img src=\"images\/cheshirecat.jpg\" \/> Cheshire Cat"],[26,"Daegon",null,"<img src=\"images\/daegon.png\" \/> Daegon"],[27,"Dampe",null,"<img src=\"images\/dampe.png\" \/> Dampe"],[28,"Dan Severn",null,"<img src=\"images\/dansevern.jpg\" \/> Dan Severn"],[29,"Daniel Carrington",null,"<img src=\"images\/danielcarrington.jpg\" \/> Daniel Carrington"],[30,"Daniel Lang",null,"<img src=\"images\/daniellang.png\" \/> Daniel Lang"],[31,"Darkman",null,"<img src=\"images\/darkman.jpg\" \/> Darkman"],[32,"Darth Vader",null,"<img src=\"images\/darthvader.jpg\" \/> Darth Vader"],[33,"Dingodile",null,"<img src=\"images\/dingodile.png\" \/> Dingodile"],[34,"Dmitri Petrovic",null,"<img src=\"images\/dmitripetrovic.png\" \/> Dmitri Petrovic"],[35,"Ebonroc",null,"<img src=\"images\/ebonroc.png\" \/> Ebonroc"],[36,"Ecco the Dolphin",null,"<img src=\"images\/eccothedolphin.png\" \/> Ecco the Dolphin"],[37,"Echidna",null,"<img src=\"images\/echidna.jpg\" \/> Echidna"],[38,"Edea Kramer",null,"<img src=\"images\/edeakramer.jpg\" \/> Edea Kramer"],[39,"Edward van Helgen",null,"<img src=\"images\/edwardvanhelgen.png\" \/> Edward van Helgen"],[40,"Elena",null,"<img src=\"images\/elena.jpg\" \/> Elena"],[41,"Eulogy Jones",null,"<img src=\"images\/eulogyjones.jpg\" \/> Eulogy Jones"],[42,"Excella Gionne",null,"<img src=\"images\/excellagionne.jpg\" \/> Excella Gionne"],[43,"Ezekial Freeman",null,"<img src=\"images\/ezekialfreeman.jpg\" \/> Ezekial Freeman"],[44,"Fakeman",null,"<img src=\"images\/fakeman.jpg\" \/> Fakeman"],[45,"Fasha",null,"<img src=\"images\/fasha.jpg\" \/> Fasha"],[46,"Fawful",null,"<img src=\"images\/fawful.jpg\" \/> Fawful"],[47,"Fergie",null,"<img src=\"images\/fergie.jpg\" \/> Fergie"],[48,"Firebrand",null,"<img src=\"images\/firebrand.jpg\" \/> Firebrand"],[49,"Fresh Prince",null,"<img src=\"images\/freshprince.jpg\" \/> Fresh Prince"],[50,"Frylock",null,"<img src=\"images\/frylock.jpg\" \/> Frylock"],[51,"Fyrus",null,"<img src=\"images\/fyrus.jpg\" \/> Fyrus"],[52,"Lamarr",null,"<img src=\"images\/lamarr.jpg\" \/> Lamarr"],[53,"Lazarus",null,"<img src=\"images\/lazarus.jpg\" \/> Lazarus"],[54,"Lebron James",null,"<img src=\"images\/lebronjames.jpg\" \/> Lebron James"],[55,"Lee Hong",null,"<img src=\"images\/leehong.jpg\" \/> Lee Hong"],[56,"Lemmy Koopa",null,"<img src=\"images\/lemmykoopa.jpg\" \/> Lemmy Koopa"],[57,"Leon Belmont",null,"<img src=\"images\/leonbelmont.jpg\" \/> Leon Belmont"],[58,"Lewton",null,"<img src=\"images\/lewton.jpg\" \/> Lewton"],[59,"Lex Luthor",null,"<img src=\"images\/lexluthor.jpg\" \/> Lex Luthor"],[60,"Lighter",null,"<img src=\"images\/lighter.jpg\" \/> Lighter"],[61,"Lulu",null,"<img src=\"images\/lulu.jpg\" \/> Lulu"]]';
	exit;

	}
}


?>