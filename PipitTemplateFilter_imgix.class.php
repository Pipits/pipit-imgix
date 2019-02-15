<?php
class PipitTemplateFilter_imgix extends PerchTemplateFilter {
    
    public function filterBeforeProcessing($value, $valueIsMarkup = false) {
        if (PERCH_PRODUCTION_MODE == PERCH_DEVELOPMENT) return $value;

        $subdomain = $query = '';
        if (defined('PIPIT_IMGIX_SUBDOMAIN')) {
            $subdomain = PIPIT_IMGIX_SUBDOMAIN;
        } else {
            PerchUtil::debug('Pipit Imgix: default subdomain is not set.', 'notice');
        }

        
        // Each Imgix source has a unique subdomain
        // Default subdomain is PIPIT_IMGIX_SUBDOMAIN. Can specify a different subdomain with a tag attribute
        // e.g. images hosted on server has a subdomain & images hosted in S3 has a different subdomain
        if ($this->Tag->subdomain) $subdomain = $this->Tag->subdomain;


        $pre = "https://$subdomain.imgix.net";
        $file = $value;

        if($this->Tag->opts) {
            $query = '?' . $this->Tag->opts;
        } else {
            $query = array();

            $attributes = $this->Tag->search_attributes_for('imgix-');
    
            foreach($attributes as $key => $val) {
                $new_key = str_replace('imgix-', '', $key);
                $query[$new_key] = $val;
            }

            $query = '?' . http_build_query($query);
        }

        
        $result = $pre . $file . $query;
        return $result;
    }
}


PerchSystem::register_template_filter('imgix', 'PipitTemplateFilter_imgix');