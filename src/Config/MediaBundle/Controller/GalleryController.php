<?php
/**
 * Created by PhpStorm.
 * User: artash
 * Date: 7/9/16
 * Time: 11:32 PM
 */

namespace Config\MediaBundle\Controller;


use Config\MediaBundle\Entity\Translations\MediaTranslations;
use Config\MediaBundle\Lib\FileManager;
use Config\MediaBundle\Model\File;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;


class GalleryController extends Controller
{
    /**
     * Create action.
     * @return Response
     * @throws \Exception
     * @internal param Request $request
     *
     */
    public function createAction()
    {
        $request = $this->getRequest();
        // the key used to lookup the template
        $templateKey = 'edit';

        $maxSize = FileManager::getMaxUploadSize() * 1000000;
        $mimeTypes = FileManager::getMimeTypes();
        $languages = $this->container->getParameter('languages');

        $this->admin->checkAccess('create');

        $class = new \ReflectionClass($this->admin->hasActiveSubClass() ? $this->admin->getActiveSubClass() : $this->admin->getClass());

        if ($class->isAbstract()) {
            return $this->render(
                'SonataAdminBundle:CRUD:select_subclass.html.twig',
                array(
                    'base_template' => $this->getBaseTemplate(),
                    'admin' => $this->admin,
                    'action' => 'create',
                ),
                null,
                $request
            );
        }

        $object = $this->admin->getNewInstance();

        $preResponse = $this->preCreate($request, $object);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();


        
        $form->setData($object);
     /*   var_dump(dump($form));
        exit;*/
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //TODO: remove this check for 4.0
            if (method_exists($this->admin, 'preValidate')) {
                $this->admin->preValidate($object);
            }
            $isFormValid = $form->isValid();
            
            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode($request) || $this->isPreviewApproved($request))) {
                $this->admin->checkAccess('create', $object);

                try {
                    $em = $this->getDoctrine()->getManager();
                    $object = $this->admin->create($object);
                    
                    if($add_images = $this->get('request')->get('all_data')){
                        foreach(json_decode($add_images) as $value){
                            $new_media = $em->getRepository('ConfigMediaBundle:Media')->getMediaWithoutGallery($value,$object->getId());
                            if($new_media == null){
                                $new_media = $em->getRepository('ConfigMediaBundle:Media')->find($value);
                                $object->addMedia($new_media);
                                $em->persist($new_media);
                            }
                        }
                    }
                    if($all_data = $this->get('request')->get('images')){
                        foreach(json_decode($all_data) as $value){
                            $new_media = $em->getRepository('ConfigMediaBundle:Media')->find($value);
                            $object->addMedia($new_media);
                            $em->persist($new_media);
                        }
                    }
                    $em->flush();
                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                            'result' => 'ok',
                            'objectId' => $this->admin->getNormalizedIdentifier($object),
                        ), 200, array());
                    }

                    $this->addFlash(
                        'sonata_flash_success',
                        $this->admin->trans(
                            'flash_create_success',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch (ModelManagerException $e) {
                    $this->handleModelManagerException($e);

                    $isFormValid = false;
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                        'sonata_flash_error',
                        $this->admin->trans(
                            'flash_create_error',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render('ConfigMediaBundle:CRUD:create.html.twig', array(
            'action' => 'create',
            'form' => $view,
            'object' => $object,
        ), null);
    }

    /**
     * Edit action.
     *
     * @param int|string|null $id
     *
     * @return Response|RedirectResponse
     *
     * @throws NotFoundHttpException If the object does not exist
     * @throws AccessDeniedException If access is not granted
     */
    public function editAction($id = null)
    {
        $request = $this->getRequest();
        // the key used to lookup the template
        $templateKey = 'edit';
        $locale = $this->container->getParameter('languages');
        $id = $request->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $id));
        }

        $this->admin->checkAccess('edit', $object);

        $preResponse = $this->preEdit($request, $object);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($object);

        /** @var $form Form */
        $form = $this->admin->getForm();
        $form->setData($object);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            //TODO: remove this check for 4.0
            if (method_exists($this->admin, 'preValidate')) {
                $this->admin->preValidate($object);
            }
            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                try {
                    $em = $this->getDoctrine()->getManager();
                    
                    $object = $this->admin->update($object);
                    
                    $images = $object->getMedia();                    
                    
                    if($all_data = $this->get('request')->get('images')){
                        foreach(json_decode($all_data) as $value){
                            $new_media = $em->getRepository('ConfigMediaBundle:Media')->find($value);
                            $object->addMedia($new_media);
                            $em->persist($new_media);
                        }
                    }
                    if($add_images = $this->get('request')->get('all_data')){
                        foreach(json_decode($add_images) as $value){
                            $new_media = $em->getRepository('ConfigMediaBundle:Media')->getMediaWithoutGallery($value,$object->getId());
                            if($new_media == null){
                                $new_media = $em->getRepository('ConfigMediaBundle:Media')->find($value);
                                $object->addMedia($new_media);
                                $em->persist($new_media);
                            }

                        }
                    }
                    
                    foreach($images as $image){
                        $locale = $this->container->getParameter('languages');
                        $position = $this->get('request')->get('image-'.$image->getId());
                        if($position == null){
                            $position = "0";
                        }
                        if($this->get('request')->get('remove-'.$image->getId())){
                            $m = $em->getRepository('ConfigMediaBundle:Media')->find($image->getId());
                            $object->removeMedia($m);
                        }


                        $fields = array('title'=>'title','caption'=>'caption','description'=>'description');

                        $image->setPosition($position);
                        if(count($image->getTranslations()) > 0) {
                            foreach ($image->getTranslations() as $ob) {
                                $ob->setContent($this->get('request')->get($ob->getField().'-' . $ob->getLocale() . '-' . $image->getId()));
                                unset($locale[$ob->getLocale()]);
                            }
                        }


                        // var_dump($locale);exit;
                        if(count($locale) > 0){
                            foreach($locale as $language=>$l){
                                foreach ($fields as $field){
                                    $tr = new MediaTranslations();
                                    $tr->setObject($image);
                                    $tr->setField($field);
                                    $tr->setLocale($language);
                                    $tr->setContent($this->get('request')->get($field.'-'.$language.'-'.$image->getId()));
                                    $em->persist($tr);
                                }

                            }
                        }

                        $em->persist($image);
                    }
                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                            'result' => 'ok',
                            'objectId' => $this->admin->getNormalizedIdentifier($object),
                            'objectName' => $this->escapeHtml($this->admin->toString($object)),
                        ), 200, array());
                    }
                    $em->flush();
                    $this->addFlash(
                        'sonata_flash_success',
                        $this->admin->trans(
                            'flash_edit_success',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch (ModelManagerException $e) {
                    $this->handleModelManagerException($e);

                    $isFormValid = false;
                } catch (LockException $e) {
                    $this->addFlash('sonata_flash_error', $this->admin->trans('flash_lock_error', array(
                        '%name%' => $this->escapeHtml($this->admin->toString($object)),
                        '%link_start%' => '<a href="'.$this->admin->generateObjectUrl('edit', $object).'">',
                        '%link_end%' => '</a>',
                    ), 'SonataAdminBundle'));
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                        'sonata_flash_error',
                        $this->admin->trans(
                            'flash_edit_error',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // enable the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render('ConfigMediaBundle:CRUD:edit.html.twig', array(
            'action' => 'edit',
            'form' => $view,
            'object' => $object,
            'languages' => $locale
        ), null);
    }
}