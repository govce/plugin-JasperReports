<?php

namespace MapasCulturais\Entities;

use Doctrine\ORM\Mapping as ORM;
use MapasCulturais\Traits;
use MapasCulturais\App;


/**
 * Agent
 *
 * @property-read \MapasCulturais\Entities\Report[] $report owned by this agent
 *
 * @ORM\Table(name="report")
 * @ORM\Entity
 * @ORM\entity(repositoryClass="MapasCulturais\Repositories\Report")
 * @ORM\HasLifecycleCallbacks
 */
class Report extends \MapasCulturais\Entity
{
    use         
        Traits\EntityFiles,
        Traits\EntityMetadata,
        Traits\EntitySoftDelete,
        Traits\EntityDraft,
        Traits\EntityPermissionCache,
        Traits\EntityOriginSubsite;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="report_id_seq", allocationSize=1, initialValue=1)
     */
    public $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    public $name;

    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    public $description;

    /**
     * @var string
     *
     * @ORM\Column(name="sql", type="text", nullable=true)
     */
    public $sql;

    /**
     * @var string
     *
     * @ORM\Column(name="params", type="text", nullable=true)
     */
    public $params;

    /**
     * @var boolean
     *
     * @ORM\Column(name="view_agent", type="boolean", nullable=false)
     */
    public $viewAgent = false;

     /**
     * @var string
     *
     * @ORM\Column(name="view_agent_ids", type="string", nullable=true)
     */
    public $viewAgentIds;

    /**
     * @var boolean
     *
     * @ORM\Column(name="view_space", type="boolean", nullable=false)
     */
    public $viewSpace = false;

     /**
     * @var string
     *
     * @ORM\Column(name="view_space_ids", type="string", nullable=true)
     */
    public $viewSpaceIds;

    /**
     * @var boolean
     *
     * @ORM\Column(name="view_event", type="boolean", nullable=false)
     */
    public $viewEvent = false;

     /**
     * @var string
     *
     * @ORM\Column(name="view_event_ids", type="string", nullable=true)
     */
    public $viewEventIds;

    /**
     * @var boolean
     *
     * @ORM\Column(name="view_project", type="boolean", nullable=false)
     */
    public $viewProject = false;

     /**
     * @var string
     *
     * @ORM\Column(name="view_project_ids", type="string", nullable=true)
     */
    public $viewProjectIds;

    /**
     * @var boolean
     *
     * @ORM\Column(name="view_opportunity", type="boolean", nullable=false)
     */
    public $viewOpportunity = false;

     /**
     * @var string
     *
     * @ORM\Column(name="view_opportunity_ids", type="string", nullable=true)
     */
    public $viewOpportunityIds;


    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_timestamp", type="datetime", nullable=false)
     */
    public $createTimestamp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_timestamp", type="datetime", nullable=true)
     */
    public $updateTimestamp;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint", nullable=false)
     */
    public $status = self::STATUS_DRAFT;

    /**
     * @var \MapasCulturais\Entities\Agent
     *
     * @ORM\ManyToOne(targetEntity="MapasCulturais\Entities\Agent", fetch="LAZY")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agent_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    protected $owner;


    /**
     * @var \MapasCulturais\Entities\ReportFieldConfiguration[] ReportFieldConfiguration
     *
     * @ORM\OneToMany(targetEntity="\MapasCulturais\Entities\ReportFieldConfiguration", mappedBy="owner", fetch="LAZY")
     * @ORM\JoinColumn(name="id", referencedColumnName="report_id", onDelete="CASCADE")
     */
    public $reportFieldConfigurations;

    /**
     * @var \MapasCulturais\Entities\ReportFile[] Files
     *
     * @ORM\OneToMany(targetEntity="\MapasCulturais\Entities\ReportFile", fetch="EXTRA_LAZY", mappedBy="owner", cascade="remove", orphanRemoval=true)
     * @ORM\JoinColumn(name="id", referencedColumnName="object_id", onDelete="CASCADE")
    */
    protected $__files;

    /**
     * @var \MapasCulturais\Entities\ReportMeta[] Metadata
     * 
     * @ORM\OneToMany(targetEntity="\MapasCulturais\Entities\ReportMeta", mappedBy="owner", cascade={"remove","persist"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="id", referencedColumnName="object_id", onDelete="CASCADE")
    */
    protected $__metadata;
       

    /**
     * @var integer
     *
     * @ORM\Column(name="subsite_id", type="integer", nullable=true)
     */
    protected $_subsiteId;

     /**
     * @var \MapasCulturais\Entities\Subsite
     *
     * @ORM\ManyToOne(targetEntity="MapasCulturais\Entities\Subsite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subsite_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     * })
     */
    protected $subsite;
   

    /**
     * Constructor
     */
    public function __construct() {
       $this->owner = App::i()->user->profile;
       parent::__construct();
    }

    public function getEntityTypeLabel($plural = false) {
        if ($plural)
            return \MapasCulturais\i::__('Relatórios');
        else
            return \MapasCulturais\i::__('Relatório');
    }

    static function getValidations() {
        return [
            'name' => [
                'required' => \MapasCulturais\i::__('O nome do agente é obrigatório')
            ]
        ];
    }

    public function save($flush = false) {
        parent::save($flush);
    }    

    //============================================================= //
    // The following lines ara used by MapasCulturais hook system.
    // Please do not change them.
    // ============================================================ //

    /** @ORM\PrePersist */
    public function prePersist($args = null){ parent::prePersist($args); }
    /** @ORM\PostPersist */
    public function postPersist($args = null){ parent::postPersist($args); }

    /** @ORM\PreRemove */
    public function preRemove($args = null){ parent::preRemove($args); }
    /** @ORM\PostRemove */
    public function postRemove($args = null){ parent::postRemove($args); }

    /** @ORM\PreUpdate */
    public function preUpdate($args = null){ parent::preUpdate($args); }
    /** @ORM\PostUpdate */
    public function postUpdate($args = null){ parent::postUpdate($args); }
}
