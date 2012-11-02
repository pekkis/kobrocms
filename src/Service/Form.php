<?php
namespace Service;

use Symfony\Component\Form\FormFactory;
use Service\Html;

class Form {
    
    /**
     * @var type 
     */
    private $formFactory;
    
    /**
     * @var type 
     */
    private $htmlService;
    
    public function __construct(FormFactory $formFactory, Html $htmlService) {
        $this->formFactory = $formFactory;
        $this->htmlService = $htmlService;
    }
    
    public function createEditHomeForm() {
        $data = array(
            'content' => $this->htmlService->getHome(),
        );

        $form = $this->formFactory->createBuilder('form', $data)
            ->add('content', 'textarea')
            ->getForm();

        return $form;
    }
    
    public function createEditAboutForm() {
        $data = array(
            'content' => $this->htmlService->getAbout(),
        );

        $form = $this->formFactory->createBuilder('form', $data)
            ->add('content', 'textarea')
            ->getForm();

        return $form;
    }
}