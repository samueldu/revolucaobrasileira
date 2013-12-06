<?php
class ModelModuleDeadcowSEO extends Model {
    public function generateCategories($template) {
        $categories = $this->getCategories();
        $slugs = array();
        foreach ($categories as $category) {
            $tags = array('[category_name]' => $category['name']);
            $slug = $uniqueSlug = $this->makeSlugs(strtr($template, $tags));
            $index = 1;
            while (in_array($uniqueSlug, $slugs)) {
                $uniqueSlug = $slug . '-' . $index++;
            }
            $slugs[] = $uniqueSlug;
            $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int)$category['category_id'] . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category['category_id'] . "', keyword = '" . $this->db->escape($uniqueSlug) . "'");
        }
    }
    
	public function generateBlog($blog_id = null, $title = null) {
        if(!is_null($blog_id) && !is_null($title)){
            $uniqueSlug = $this->makeSlugs($title);
            $index = 1;
            $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'blog_id=" . (int)$blog_id . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'blog_id=" . (int)$blog_id . "', keyword = '" . $this->db->escape($uniqueSlug) . "'");
        }
    }

    public function generateProducts($template) {
        $products = $this->getProducts();
        $slugs = array();
        foreach ($products as $product) {
            $tags = array('[product_name]' => $product['name'],
                          '[model_name]' => $product['model']
            );
            $slug = $uniqueSlug = $this->makeSlugs(strtr($template, $tags));
            $index = 1;
            while (in_array($uniqueSlug, $slugs)) {
                $uniqueSlug = $slug . '-' . $index++;
            }
            $slugs[] = $uniqueSlug;
            $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product['product_id'] . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product['product_id'] . "', keyword = '" . $this->db->escape($uniqueSlug) . "'");
        }
    }

    public function generateManufacturers($template) {
        $manufacturers = $this->getManufacturers();
        $slugs = array();
        foreach ($manufacturers as $manufacturer) {
            $tags = array('[manufacturer_name]' => $manufacturer['name']);
            $slug = $uniqueSlug = $this->makeSlugs(strtr($template, $tags));
            $index = 1;
            while (in_array($uniqueSlug, $slugs)) {
                $uniqueSlug = $slug . '-' . $index++;
            }
            $slugs[] = $uniqueSlug;
            $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int)$manufacturer['manufacturer_id'] . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$manufacturer['manufacturer_id'] . "', keyword = '" . $this->db->escape($uniqueSlug) . "'");
        }
    }

    public function generateMetaKeywords($template, $yahooID = null) {
        $products = $this->getProductsForMetaKeywords();
        $slugs = array();
        
        $storeName = $this->getStoreName();
        
        foreach ($products as $product) {
            $finalCategories = array();
            $categories = $this->getProductCategories($product['product_id'], $product['language_id']);
            foreach ($categories as $category) {
                $finalCategories[] = $category['name'];
                
                if(substr_count($category['name'], " ")){  
                	
                	$auxCat = explode(" ",$category['name']);
                	
                	foreach($auxCat as $key=>$value)
                	{
						if(strlen($value) > 2 and $value != "para")
						{
							$finalCategories[] = $value;
						}
                	}
                }  
            }
             
            $tags = array('[product_name]' => $product['name'],
                          '[model_name]' => $product['model'],
                          '[manufacturer_name]' => $product['manufacturer_name'],
                          '[categories_names]' => implode(',', $finalCategories),
                          '[store_name]' => $storeName   

            );
            $finalKeywords = array();
            $keywords = explode(',', strtr($template['meta_template'], $tags));
            if ($yahooID != null) {
                $keywords = array_merge($keywords, $this->getYahooKeywords($yahooID, $product['description']));
            }
            foreach ($keywords as $keyword) {
                $finalKeywords[] = $this->makeSlugs(trim($keyword));
            }
            $finalKeywords = array_filter(array_unique($finalKeywords));
            $finalKeywords = str_replace('-', ' ', implode(', ', $finalKeywords));
            
            $finalDescription = array();
            $description = explode(',', strtr($template['meta_template_description'], $tags));
            if ($yahooID != null) {
                $description = array_merge($description, $this->getYahooKeywords($yahooID, $product['description']));
            }
            foreach ($description as $descriptions) {
                $finalDescription[] = $this->makeSlugs(trim($descriptions));
            }
            $finalDescription = array_filter(array_unique($finalDescription));
            $finalDescription = str_replace('-', ' ', implode(', ', $finalDescription));
            
            $this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_keywords = '" . $this->db->escape($finalKeywords) . "',  meta_description = '" . $this->db->escape($finalDescription) . "' where product_id = " . (int)$product['product_id'] . " and language_id = " . (int)$product['language_id']);
        }  
    }
    
     public function generateMetaKeywordsCat($template, $yahooID = null) {
     	 
        $products = $this->getCategoriesForMetaKeywords();
        $slugs = array();
        $storeName = $this->getStoreName();

        foreach ($products as $product) {
        	
        	$finalCategories = array();
        	
        	$finalCategories[] = $product['name'];
        	
        	$tags = array('[categories_names]' => implode(',', $finalCategories),
                          '[store_name]' => $storeName);
                          
            $finalKeywords = array();
            $keywords = explode(',', strtr($template['meta_template_cat'], $tags));

            foreach ($keywords as $keyword) {
                $finalKeywords[] = $this->makeSlugs(trim($keyword));
            }
            $finalKeywords = array_filter(array_unique($finalKeywords));
            $finalKeywords = str_replace('-', ' ', implode(', ', $finalKeywords));
            
            $finalDescription = array();
            $description = explode(',', strtr($template['meta_template_cat_description'], $tags));

            foreach ($description as $descriptions) {
                $finalDescription[] = $this->makeSlugs(trim($descriptions));
            }
            
            $finalDescription = array_filter(array_unique($finalDescription));
            $finalDescription = str_replace('-', ' ', implode(', ', $finalDescription));
        	
        	$this->db->query("UPDATE " . DB_PREFIX . "category_description SET meta_keywords = '" . $this->db->escape($finalKeywords) . "',  meta_description = '" . $this->db->escape($finalDescription) . "' where category_id = " . (int)$product['category_id'] . " and language_id = " . (int)$this->config->get('config_language_id'));
        	
            $categories = $this->getSubCategoriesForMetaKeywords($product['category_id']);
             
            foreach ($categories as $category) {
            	
            	$finalCategories = array();
            	
            	$finalCategories[] = $product['name'];
            	
                $finalCategories[] = $category['name'];
            
              
            $tags = array('[categories_names]' => implode(',', $finalCategories),
                          '[store_name]' => $storeName);
                          
            $finalKeywords = array();
            $keywords = explode(',', strtr($template['meta_template_cat'], $tags));

            foreach ($keywords as $keyword) {
                $finalKeywords[] = $this->makeSlugs(trim($keyword));
            }
            $finalKeywords = array_filter(array_unique($finalKeywords));
            $finalKeywords = str_replace('-', ' ', implode(', ', $finalKeywords));
            
            $finalDescription = array();
            $description = explode(',', strtr($template['meta_template_cat_description'], $tags));

            foreach ($description as $descriptions) {
                $finalDescription[] = $this->makeSlugs(trim($descriptions));
            }
            
            $finalDescription = array_filter(array_unique($finalDescription));
            $finalDescription = str_replace('-', ' ', implode(', ', $finalDescription));
            
 //           print "UPDATE " . DB_PREFIX . "category_description SET meta_keywords = '" . $this->db->escape($finalKeywords) . "',  meta_description = '" . $this->db->escape($finalDescription) . "' where category_id = '" . (int)$product['category_id'] . "' and language_id = " . (int)$this->config->get('config_language_id');

            $this->db->query("UPDATE " . DB_PREFIX . "category_description SET meta_keywords = '" . $this->db->escape($finalKeywords) . "',  meta_description = '" . $this->db->escape($finalDescription) . "' where category_id = " . (int)$category['category_id'] . " and language_id = " . (int)$this->config->get('config_language_id'));
            
			}
        }  
    }

    private function getYahooKeywords($yahooID, $description) {
        $keywords = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://search.yahooapis.com/ContentAnalysisService/V1/termExtraction');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'appid=' . $yahooID . '&output=php&context=' . urlencode(strip_tags(html_entity_decode($description, ENT_QUOTES, "UTF-8"))));
        $output = curl_exec($ch);
        curl_close($ch);
        if ($output) {
            $output = unserialize($output);
            if (isset($output['ResultSet']['Result'])) {
                $keywords = $output['ResultSet']['Result'];
                if (!is_array($keywords)) {
                    $keywords = array($keywords);
                }
            }
        }
        return $keywords;
    }

    private function getCategories() {
        $query = $this->db->query("SELECT c.category_id, cd.name FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
        return $query->rows;
    }
    
    private function getCategoriesForMetaKeywords() {
        $query = $this->db->query("SELECT c.category_id, cd.name FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' and c.parent_id = '0' ORDER BY c.sort_order, cd.name ASC");
        return $query->rows;
    }
    
    private function getSubCategoriesForMetaKeywords($id) {
        $query = $this->db->query("SELECT c.category_id, cd.name FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' and c.parent_id = '$id'  ORDER BY c.sort_order, cd.name ASC");
        return $query->rows;
    }
    
    private function getStoreName() {
        $query = $this->db->query("SELECT setting.value as store_name FROM " . DB_PREFIX . "setting where setting.key = 'config_name'");
        
        $auxName = "";
        
		if(substr_count($query->row['store_name'], " ")){  

			$auxCat = explode(" ",$query->row['store_name']);

			foreach($auxCat as $key=>$value)
			{
				if(strlen($value) > 2 and $value != "para")
				{
					$auxName .= $value.", ";
				}
			}
			
			$auxName = substr($auxName,0,strlen($auxName)-2);
		}
		
		if($auxName != "")
        return $query->row['store_name'].", ".$auxName;
        else
        return $query->row['store_name'];
    }

    private function getProductCategories($productId, $languageId) {
        $query = $this->db->query("SELECT c.category_id, cd.name FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) INNER JOIN " . DB_PREFIX . "product_to_category pc ON (pc.category_id = c.category_id) WHERE cd.language_id = " . (int)$languageId . " AND pc.product_id = " . (int)$productId . " ORDER BY c.sort_order, cd.name ASC");
        return $query->rows;
    }

    private function getProducts() {
        $query = $this->db->query("SELECT p.product_id, pd.name, p.model FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY pd.name ASC");
        return $query->rows;
    }


    private function getManufacturers() {
        $query = $this->db->query("SELECT m.manufacturer_id, m.name FROM " . DB_PREFIX . "manufacturer m ORDER BY m.name ASC");
        return $query->rows;
    }

    private function getProductsForMetaKeywords() {
        $query = $this->db->query("SELECT p.product_id, pd.name, p.model, m.name as manufacturer_name, pd.description, pd.language_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) ORDER BY pd.name ASC");
        return $query->rows;
    }

    // Taken from http://code.google.com/p/php-slugs/
    private function my_str_split($string) {
        $slen = strlen($string);
        for ($i = 0; $i < $slen; $i++) {
            $sArray[$i] = $string{$i};
        }
        return $sArray;
    }

    private function noDiacritics($string) {
        $chars = array(
            "А" => "A",
            "Б" => "B",
            "В" => "V",
            "Г" => "G",
            "Д" => "D",
            "Є" => "E",
            "Е" => "JE",
            "Ё" => "JO",
            "Ж" => "ZH",
            "З" => "Z",
            "И" => "I",
            "Й" => "J",
            "К" => "K",
            "Л" => "L",
            "М" => "M",
            "Н" => "N",
            "О" => "O",
            "П" => "P",
            "Р" => "R",
            "С" => "S",
            "Т" => "T",
            "У" => "U",
            "Ф" => "F",
            "Х" => "KH",
            "Ц" => "TS",
            "Ч" => "CH",
            "Ш" => "SH",
            "Щ" => "SHCH",
            "Ъ" => "",
            "Ы" => "Y",
            "Ь" => "",
            "Э" => "E",
            "Ю" => "JU",
            "Я" => "JA",
            "Ґ" => "G",
            "Ї" => "I",
            "а" => "a",
            "б" => "b",
            "в" => "v",
            "г" => "g",
            "д" => "d",
            "є" => "e",
            "е" => "je",
            "ё" => "jo",
            "ж" => "zh",
            "з" => "z",
            "и" => "i",
            "й" => "j",
            "к" => "k",
            "л" => "l",
            "м" => "m",
            "н" => "n",
            "о" => "o",
            "п" => "p",
            "р" => "r",
            "с" => "s",
            "т" => "t",
            "у" => "u",
            "ф" => "f",
            "х" => "kh",
            "ц" => "ts",
            "ч" => "ch",
            "ш" => "sh",
            "щ" => "shch",
            "ъ" => "",
            "ы" => "y",
            "ь" => "",
            "э" => "e",
            "ю" => "ju",
            "я" => "ja",
            "ґ" => "g",
            "ї" => "i",
            'á' => 'a',
            'č' => 'c',
            'ď' => 'd',
            'é' => 'e',
            'ě' => 'e',
            'í' => 'i',
            'ň' => 'n',
            'ó' => 'o',
            'ř' => 'r',
            'š' => 's',
            'ť' => 't',
            'ú' => 'u',
            'ů' => 'u',
            'ý' => 'y',
            'ž' => 'z',
            'Á' => 'A',
            'Č' => 'C',
            'Ď' => 'D',
            'É' => 'E',
            'Ě' => 'E',
            'Í' => 'I',
            'Ň' => 'N',
            'Ó' => 'O',
            'Ř' => 'R',
            'Š' => 'S',
            'Ť' => 'T',
            'Ú' => 'U',
            'Ů' => 'U',
            'Ý' => 'Y',
            'Ž' => 'Z',
            'ä' => 'ae',
            'ë' => 'e',
            'ï' => 'i',
            'ö' => 'oe',
            'ü' => 'ue',
            'Ä' => 'Ae',
            'Ë' => 'E',
            'Ï' => 'I',
            'Ö' => 'Oe',
            'Ü' => 'Ue',
            'ß' => 'ss',
            'â' => 'a',
            'ê' => 'e',
            'î' => 'i',
            'ô' => 'o',
            'û' => 'u',
            'Â' => 'A',
            'Ê' => 'E',
            'Î' => 'I',
            'Ô' => 'O',
            'Û' => 'U',
            'œ' => 'oe',
            'æ' => 'ae',
            'Ÿ' => 'Y',
            'ç' => 'c',
            'Ç' => 'C',
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ö' => 'o',
            'ő' => 'o',
            'ú' => 'u',
            'ü' => 'u',
            'ű' => 'u',
            'ą' => 'a',
            'ę' => 'e',
            'ó' => 'o',
            'ć' => 'c',
            'ł' => 'l',
            'ń' => 'n',
            'ś' => 's',
            'ż' => 'z',
            'ź' => 'z',
            'Ó' => 'O',
            'Ć' => 'C',
            'Ł' => 'L',
            'Ś' => 'S',
            'Ż' => 'Z',
            'Ź' => 'Z',
            'æ' => 'ae',
            'ø' => 'oe',
            'å' => 'aa',
            'Æ' => 'Ae',
            'Ø' => 'Oe',
            'Å' => 'Aa',
            'Č' => 'C',
            'Ć' => 'C',
            'Ž' => 'Z',
            'Š' => 'S',
            'Đ' => 'D',
            'č' => 'c',
            'ć' => 'c',
            'ž' => 'z',
            'š' => 's',
            'đ' => 'd',
            'À' => 'A',
            'Ă' => 'A',
            'Ā' => 'A',
            'Ã' => 'A',
            'Ą' => 'A',
            'Ċ' => 'C',
            'Ĉ' => 'C',
            'Ð' => 'D',
            'È' => 'E',
            'Ė' => 'E',
            'Ē' => 'E',
            'Ę' => 'E',
            'Ə' => 'G',
            'Ġ' => 'G',
            'Ĝ' => 'G',
            'Ğ' => 'G',
            'Ģ' => 'G',
            'à' => 'a',
            'ă' => 'a',
            'ā' => 'a',
            'ã' => 'a',
            'ċ' => 'c',
            'ĉ' => 'c',
            'ð' => 'd',
            'è' => 'e',
            'ė' => 'e',
            'ē' => 'e',
            'ə' => 'g',
            'ġ' => 'g',
            'ĝ' => 'g',
            'ğ' => 'g',
            'ģ' => 'g',
            'Ĥ' => 'H',
            'Ħ' => 'H',
            'I' => 'I',
            'Ì' => 'I',
            'İ' => 'I',
            'Ī' => 'I',
            'Į' => 'I',
            'Ĳ' => 'IJ',
            'Ĵ' => 'J',
            'Ķ' => 'K',
            'Ļ' => 'L',
            'Ń' => 'N',
            'Ñ' => 'N',
            'Ņ' => 'N',
            'Ò' => 'O',
            'Õ' => 'O',
            'Ő' => 'O',
            'Ơ' => 'O',
            'Œ' => 'CE',
            'ĥ' => 'h',
            'ħ' => 'h',
            'ı' => 'i',
            'ì' => 'i',
            'i' => 'i',
            'ī' => 'i',
            'į' => 'i',
            'ĳ' => 'ij',
            'ĵ' => 'j',
            'ķ' => 'k',
            'ļ' => 'l',
            'ñ' => 'n',
            'ņ' => 'n',
            'ò' => 'o',
            'õ' => 'o',
            'ơ' => 'o',
            'Ŕ' => 'R',
            'Ŝ' => 'S',
            'Ş' => 'S',
            'Ţ' => 'T',
            'Þ' => 'T',
            'Ù' => 'U',
            'Ŭ' => 'U',
            'Ū' => 'U',
            'Ų' => 'U',
            'Ű' => 'U',
            'Ư' => 'U',
            'Ŵ' => 'W',
            'Ŷ' => 'Y',
            'ŕ' => 'r',
            'ŝ' => 's',
            'ş' => 's',
            'ţ' => 't',
            'þ' => 'b',
            'ù' => 'u',
            'ŭ' => 'u',
            'ū' => 'u',
            'ų' => 'u',
            'ư' => 'u',
            'ŵ' => 'w',
            'ŷ' => 'y',
            'ÿ' => 'y',
        );
        return strtr(html_entity_decode($string, ENT_QUOTES, "UTF-8"), $chars);
    }

    private function makeSlugs($string, $maxlen = 0) {
        $newStringTab = array();
        $string = strtolower($this->noDiacritics($string));
        if (function_exists('str_split')) {
            $stringTab = str_split($string);
        } else {
            $stringTab = $this->my_str_split($string);
        }
        $numbers = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "-");
        foreach ($stringTab as $letter) {
            if (in_array($letter, range("a", "z")) || in_array($letter, $numbers)) {
                $newStringTab[] = $letter;
            } elseif ($letter == " ") {
                $newStringTab[] = "-";
            }
        }
        if (count($newStringTab)) {
            $newString = implode($newStringTab);
            if ($maxlen > 0) {
                $newString = substr($newString, 0, $maxlen);
            }
            $newString = $this->removeDuplicates('--', '-', $newString);
        } else {
            $newString = '';
        }
        return $newString;
    }

    private function removeDuplicates($sSearch, $sReplace, $sSubject) {
        $i = 0;
        do {
            $sSubject = str_replace($sSearch, $sReplace, $sSubject);
            $pos = strpos($sSubject, $sSearch);
            $i++;
            if ($i > 100) {
                die('removeDuplicates() loop error');
            }
        } while ($pos !== false);
        return $sSubject;
    }
}