<?php
namespace MapasCulturais\Entities;

use Doctrine\ORM\Mapping as ORM;
use MapasCulturais\App;

/**
 * @ORM\Entity
 * @ORM\entity(repositoryClass="MapasCulturais\Repository")
 */
class ReportFile extends \MapasCulturais\Entities\File{

    /**
     * @var \MapasCulturais\Entities\Report
     *
     * @ORM\ManyToOne(targetEntity="MapasCulturais\Entities\Report")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $owner;

    /**
     * @var \MapasCulturais\Entities\ReportFile
     *
     * @ORM\ManyToOne(targetEntity="MapasCulturais\Entities\ReportFile", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    protected $parent;
}