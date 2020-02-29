<?php
class PipitTemplateFilter_imgix extends PerchTemplateFilter {
    
    public function filterBeforeProcessing($value, $valueIsMarkup = false) {
        $subdomain = $query = '';
        $allow_dev = false;
        if(defined('PIPIT_IMGIX_DEV')) $allow_dev = PIPIT_IMGIX_DEV;

        if(!$allow_dev) {
            if (PERCH_PRODUCTION_MODE == PERCH_DEVELOPMENT || PERCH_PRODUCTION_MODE == PERCH_STAGING) {
                return $value;
            }
        }

        if(!defined('PIPIT_IMGIX_SUBDOMAIN') && !$this->Tag->subdomain) {
            PerchUtil::debug('Imgix subdomain is not set.', 'notice');
            return $value;
        }

        
        // Each Imgix source has a unique subdomain
        // Default subdomain is PIPIT_IMGIX_SUBDOMAIN. Can specify a different subdomain with a tag attribute
        // e.g. images hosted on server has a subdomain & images hosted in S3 has a different subdomain
        if ($this->Tag->subdomain) {
            $subdomain = $this->Tag->subdomain;
        } else {
            $subdomain = PIPIT_IMGIX_SUBDOMAIN;
        }


        $pre = "https://$subdomain.imgix.net";
        $file = $value;


        if($this->Tag->imgix_opts) {
            $query = '?' . $this->_replace_vars($this->Tag->imgix_opts, $this->content);
        } elseif($this->Tag->opts) {
            $query = '?' . $this->_replace_vars($this->Tag->opts, $this->content);
        } else {
            $query = array();

            $attributes = $this->Tag->search_attributes_for('imgix-');
    
            foreach($attributes as $key => $val) {
                $new_key = str_replace('imgix-', '', $key);
                $query[$new_key] = $this->_replace_vars($val, $this->content);;
            }

            $query = '?' .http_build_query($query);
        }

        
        $result = $pre . $file . $query;
        return $result;
    }





    /**
     * @param string $opts
     * @param array $vars
     * @return string
     */
    private function _replace_vars($opts, $vars) {
        $out =  preg_replace_callback('/{([A-Za-z0-9_\-]+)}/', function($matches) use($vars) {
            if (isset($vars[$matches[1]])) {

                if(!is_array( $vars[$matches[1]] )) {
                    return $vars[$matches[1]];
                } elseif(isset( $vars[$matches[1]]['_default'] )) {
                    return $vars[$matches[1]]['_default'];
                }

            }
        }, $opts);
        
        return $out;
    }
}


PerchSystem::register_template_filter('imgix', 'PipitTemplateFilter_imgix');