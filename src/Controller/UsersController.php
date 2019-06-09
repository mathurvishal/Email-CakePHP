<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\Email;
use Cake\Network;
use Cake\Mailer\TransportFactory;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        /*Email */
        /*TransportFactory::setConfig('mailtrap', [
            'host' => 'smtp.mailtrap.io',
            'port' => 2525,
            'username' => '6600d71fde4bd9',
            'password' => '71c59dde779884',
            'className' => 'Smtp'
        ]);*/
        $email = new Email('default'); //To load a predefined configuration
        //$email->setProfile('default');
        //pr($email); die;
        /*Quick Send*/
        /*try {
              $email->deliver('connect@vishalmathur.in', 'Subject', 'Message', ['from' => 'connect@vishalmathur.in']);
              echo("success");
          }
          catch (Exception $e){
              echo 'Exception : ',  $e->getMessage(), "\n";
          }*/

        $email->setFrom(['connect@vishalmathur.in' => 'vishalmathur.in'])
            ->setTo('connect@vishalmathur.in', 'Vishal Mathur gmail')
            ->addTo('mathurvishal@outlook.com', 'Vishal Mathur Outlook')
            //->template('view_welcome', 'layout_fancy')
            ->setBcc('bcc@vishalmathur.in')
            ->setCc('cc@vishalmathur.in')
            ->setEmailFormat('html')
            ->setViewVars(['value' => 12345])
            ->setSubject('About test email')
            ->setAttachments([
                'cake.gif' => [
                    'file' => WWW_ROOT.'/img/cake.power.gif',
                    'mimetype' => 'file/gif',
                    'contentId' => '4132432432'
                ]
            ])
            ->viewBuilder()->setTemplate('view_welcome')
            ->setLayout('layout_fancy');

        if ($email->send('My message')){
            echo 'success';
        }
        else{
            echo 'fail';
        }



        die;

        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
