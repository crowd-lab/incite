<?php

/**
 * The Incite plugin.
 *
 * @package Omeka\Plugins\Incite
 */
class IncitePlugin extends Omeka_Plugin_AbstractPlugin 
{  
    protected $_hooks = array(
        'install',
        'uninstall',
        'config_form',
        'config',
        'define_routes',
        'public_items_show',
        'public_head',
    );

    /**
     * Create the database tables
     */
    public function hookInstall() {
        $db = get_db();
        $db->query(<<<SQL
    CREATE TABLE IF NOT EXISTS {$db->prefix}incite_documents (
        `id`                    int(11) NOT NULL AUTO_INCREMENT,
        `item_id`               int(11) NOT NULL,
        `user_id`               int(11) NOT NULL,
        `tags_ignored`          int(11) NOT NULL,
        `is_locked`             int(11) NOT NULL,
        `document_difficulty`   int(11) NOT NULL,
        `question_id`           int(11) NOT NULL,
        `Timestamp`             timestamp NOT NULL,
  
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
SQL
        );

        get_db()->query(<<<SQL
    CREATE TABLE IF NOT EXISTS {$db->prefix}incite_group (
        `id`                int(11) NOT NULL AUTO_INCREMENT,
        `group_type`        int(11) NOT NULL,
        `timestamp`         timestamp NOT NULL,
        
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
SQL
        );
        get_db()->query(<<<SQL
      CREATE TABLE IF NOT EXISTS `omeka_incite_documents_subject_conjunction` (
        `id`                    int(11) NOT NULL AUTO_INCREMENT,
        `document_id`           int(11) NOT NULL,
        `subject_concept_id`    int(11) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
SQL
                );
        get_db()->query(<<<SQL
    CREATE TABLE IF NOT EXISTS {$db->prefix}incite_documents_tags_conjunction (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `document_id` int(11) NOT NULL,
        `tag_id` int(11) NOT NULL,
                
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;       
SQL
        );

        get_db()->query(<<<SQL
   CREATE TABLE IF NOT EXISTS {$db->prefix}incite_group_members (
        `id`            int(11) NOT NULL AUTO_INCREMENT,
        `user_id`       int(11) NOT NULL,
        `group_id`      int(11) NOT NULL,
        `privilege`     int(11) NOT NULL,
        
        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
SQL
        );
   
        get_db()->query(<<<SQL
   CREATE TABLE IF NOT EXISTS {$db->prefix}incite_questions (
        `id`                    int(11) NOT NULL AUTO_INCREMENT,
        `user_id`               int(11) NOT NULL,
        `question_text`         varchar(1000) NOT NULL,
        `document_id`           int(11) NOT NULL,
        `document_reference`    int(11) NOT NULL,
        `timestamp`             timestamp NOT NULL,
  
        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
SQL
        );

        get_db()->query(<<<SQL
   CREATE TABLE IF NOT EXISTS {$db->prefix}incite_replies (
        `id`            int(11) NOT NULL AUTO_INCREMENT,
        `user_id`       int(11) NOT NULL,
        `reply_text`    varchar(500) NOT NULL,
        `document_id`   int(11) NOT NULL,
        `question_id`   int(11) NOT NULL,
        `reply_id`      int(11) NOT NULL,
        `is_active`     int(11) NOT NULL,
        `timestamp`     timestamp NOT NULL,
        
        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
SQL
        );

        get_db()->query(<<<SQL
   CREATE TABLE IF NOT EXISTS {$db->prefix}incite_subject_concepts (
        `id`            int(11) NOT NULL AUTO_INCREMENT,
        `name`          varchar(60) NOT NULL,
        `definition`    varchar(500) NOT NULL,
        
        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;  
SQL
        );
        get_db()->query(<<<SQL
    INSERT INTO {$db->prefix}incite_subject_concepts (`id`, `name`, `definition`) VALUES (NULL, 'Religion', 'This document talks about worship of a god'), (NULL, 'White Supremacy', 'This document talks about the belief that white people are superior to other races'), (NULL, 'Racial Equality', 'This document talks about equal regard to all races'), (NULL, 'Gender Equality/Inequality', 'This document talks about equal regard or complete disregard in relation to one''s gender'), (NULL, 'Human Equality', 'This document talks about all humans being equal'), (NULL, 'Self Goverment', 'This document talks about people who want a country to be ruled by it''s own people'), (NULL, 'America as a Global Beacon', 'This document talks about America''s domination in the world'), (NULL, 'Celebration of Revolutionary Generation', 'This document talks about celebrations in regards to the first generation post-civil war');
SQL
   );

        get_db()->query(<<<SQL
   CREATE TABLE IF NOT EXISTS {$db->prefix}incite_tags (
        `id`                    int(11) NOT NULL AUTO_INCREMENT,
        `user_id`               int(11) NOT NULL,
        `tag_text`              varchar(30) NOT NULL,
        `created_timestamp`     timestamp NOT NULL,
        `category_name`         varchar(30) NOT NULL,
        `description`           varchar(300) NOT NULL,
  
        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
SQL
        );

        get_db()->query(<<<SQL
   CREATE TABLE IF NOT EXISTS {$db->prefix}incite_transcriptions (
        `id`                    int(11) NOT NULL AUTO_INCREMENT,
        `document_id`           int(11) NOT NULL,
        `user_id`               int(11) NOT NULL,
        `transcribed_text`      varchar(5000) NOT NULL,
        `summarized_text`       varchar(1000) NOT NULL,
        `is_approved`           int(11) NOT NULL,
        `timestamp_approval`    timestamp NULL DEFAULT NULL,
        `timestamp_creation`    timestamp NOT NULL,
        
        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
SQL
        );

        get_db()->query(<<<SQL
   CREATE TABLE IF NOT EXISTS {$db->prefix}incite_users (
        `id`                int(11) NOT NULL AUTO_INCREMENT,
        `first_name`        varchar(15) NOT NULL,
        `last_name`         varchar(15) NOT NULL,
        `email`             varchar(30) NOT NULL,
        `password`          varchar(32) NOT NULL,
        `privilege_level`   int(11) NOT NULL,
        `experience_level`  int(11) NOT NULL,
        `is_active`         int(11) NOT NULL,
        `timestamp`         timestamp NOT NULL,
        
        PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
SQL
        );
        get_db()->query(<<<SQL
    CREATE TABLE IF NOT EXISTS {$db->prefix}incite_tags_subcategory (
        `id`                int(10) unsigned NOT NULL AUTO_INCREMENT,
        `name`              varchar(30) NOT NULL,
        `category_id`       int(10) unsigned NOT NULL,
        `created_by`        int(10) unsigned NOT NULL,
        `timestamp`         timestamp NOT NULL,
  
        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
SQL
    );
        get_db()->query(<<<SQL
      INSERT INTO {$db->prefix}incite_tags_subcategory (`id`, `name`, `category_id`, `timestamp`) VALUES (NULL, 'State', 1, NULL), (NULL, 'City', 1, NULL), (NULL, 'Town', 1, NULL), (NULL, 'Building', 1, NULL), (NULL, 'Oration', 2, NULL), (NULL, 'Banquet', 2, NULL), (NULL, 'Fireworks', 2, NULL), (NULL, 'Parade', 2, NULL), (NULL, 'Reading of Declaration', 2, NULL), (NULL, 'Prayer', 2, NULL), (NULL, 'Excursion', 2, NULL), (NULL, 'Music', 2, NULL), (NULL, 'White Southerners', 3, NULL), (NULL, 'White Northerners', 3, NULL), (NULL, 'African Americans', 3, NULL), (NULL, 'Women', 3, NULL), (NULL, 'Immigrants',3, NULL), (NULL, 'Whigs', 3, NULL), (NULL, 'Democrats', 3, NULL), (NULL, 'Republicans', 3, NULL), (NULL, 'Military', 4, NULL), (NULL, 'Social', 4, NULL), (NULL, 'Charity', 4, NULL), (NULL, 'Business', 4, NULL), (NULL, 'Religious', 4, NULL), (NULL, 'Political', 4, NULL);
   
SQL
    );
    
        get_db()->query(<<<SQL
    CREATE TABLE IF NOT EXISTS {$db->prefix}incite_tags_category (
        `id`            int(11) NOT NULL AUTO_INCREMENT,
        `name`          varchar(30) NOT NULL,
  
        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1; 
SQL
   );
        get_db()->query(<<<SQL
    INSERT INTO {$db->prefix}incite_tags_category (`id`, `name`) VALUES (NULL, 'Location'), (NULL, 'Event'), (NULL, 'People'), (NULL, 'Organization');
    
SQL
   );
            get_db()->query(<<<SQL
    CREATE TABLE IF NOT EXISTS {$db->prefix}incite_users_map (
        `non_guest_id`  int(10) unsigned NOT NULL,
        `guest_id`      int(10) unsigned NOT NULL
                
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;  
SQL
    );
        get_db()->query(<<<SQL
    CREATE TABLE IF NOT EXISTS {$db->prefix}incite_tags_subcategory_conjunction (
        `tag_id`            int(11) NOT NULL,
        `subcategory_id`    int(11) NOT NULL
    
) ENGINE=InnoDB DEFAULT CHARSET=latin1;    
   
SQL
    );    
}

    /**
     * remove the database tables
     */
    public function hookUninstall() {
                $db = get_db();
        $db->query(<<<SQL
        DROP TABLE IF EXISTS {$this->_db->prefix}incite_category_table
SQL
        );
        get_db()->query(<<<SQL
      DROP TABLE IF EXISTS {$this->_db->prefix}incite_documents
SQL
        );
        get_db()->query(<<<SQL
      DROP TABLE IF EXISTS {$this->_db->prefix}incite_group
SQL
        );
        get_db()->query(<<<SQL
      DROP TABLE IF EXISTS {$this->_db->prefix}incite_group_members
SQL
        );
        get_db()->query(<<<SQL
      DROP TABLE IF EXISTS {$this->_db->prefix}incite_questions
SQL
        );
        get_db()->query(<<<SQL
      DROP TABLE IF EXISTS {$this->_db->prefix}incite_replies
SQL
        );
        get_db()->query(<<<SQL
      DROP TABLE IF EXISTS {$this->_db->prefix}incite_subject_concepts
SQL
        );
        get_db()->query(<<<SQL
      DROP TABLE IF EXISTS {$this->_db->prefix}incite_tags
SQL
        );
        get_db()->query(<<<SQL
      DROP TABLE IF EXISTS {$this->_db->prefix}incite_transcriptions
SQL
        );
        get_db()->query(<<<SQL
      DROP TABLE IF EXISTS {$this->_db->prefix}incite_users
SQL
        );
      
      get_db()->query(<<<SQL
    DROP TABLE IF EXISTS {$this->_db->prefix}incite_documents_tags_conjunction
SQL
              );
     get_db()->query(<<<SQL
    DROP TABLE IF EXISTS {$this->_db->prefix}incite_tags_category
SQL
   );
    get_db()->query(<<<SQL
    DROP TABLE IF EXISTS {$this->_db->prefix}incite_tags_subcategory
SQL
   );
    get_db()->query(<<<SQL
    DROP TABLE IF EXISTS {$this->_db->prefix}incite_tags_subcategory_conjunction
SQL
   );
    get_db()->query(<<<SQL
    DROP TABLE IF EXISTS {$this->_db->prefix}incite_documents_subject_conjunction
SQL
   );
    get_db()->query(<<<SQL
    DROP TABLE IF EXISTS {$db->prefix}incite_users_map
SQL
   );
    }

    /**
     * Display the config form.
     */
    public function hookConfigForm() {
        require 'config-form.php';
    }

    /**
     * Handle the config form.
     */
    public function hookConfig() {
        set_option('text_test', trim($_POST['text_test']));
    }

    /**
     * Controller triggering on /incite/stage/ACTIONS,
     */
    public function hookPublicHead($args) {
        get_view()->addHelperPath(dirname(__FILE__) . '/views/helpers', 'Incite_View_Helper_');
    }

    /**
     * Print out configured message on item show
     */
    public function hookPublicItemsShow() {
        echo '<p>' . get_option('text_test') . '</p>';
    }

    public function hookDefineRoutes($args) {
        /*
          if (!defined('EXHIBIT_PLUGIN_DIR')) {
          define('EXHIBIT_PLUGIN_DIR', dirname(__FILE__));
          }
         */
        $router = $args['router'];
//    	    $router->addConfig(new Zend_Config_Ini(EXHIBIT_PLUGIN_DIR .
//        DIRECTORY_SEPARATOR . 'routes.ini', 'routes'));
///*	    
        $route = new Zend_Controller_Router_Route(
                'incite/:controller/:action/:id', array(
            'module' => 'incite',
            'controller' => 'documents',
            'action' => 'index')
        );
        $router->addRoute('incite', $route);
//*/
        //print_r($router);
    }


}
