<?php

/*
 * This file is part of the AndroIRC website.
 *
 * (c) 2010-2012 Julien Brochet <mewt@androirc.com>
 * (c) 2010-2012 Sébastien Brochet <blinkseb@androirc.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Madalynn\Bundle\MainBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Madalynn\Bundle\MainBundle\Validator\Constraints as AndroAssert;

/**
 * @ORM\Entity(repositoryClass="Madalynn\Bundle\MainBundle\Repository\UserRepository")
 * @ORM\Table(name="andro_user")
 * @ORM\HasLifecycleCallbacks
 *
 * @AndroAssert\Password(passwordProperty="password", plainPasswordProperty="plainPassword")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(length=255, unique=true)
     */
    protected $username;

    /**
     * @ORM\Column(length=255, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column
     */
    protected $password;

    protected $plainPassword;

    /**
     * @ORM\Column
     */
    protected $salt;

    /**
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="andro_user_role",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     *
     * @param Doctrine\Common\Collections\ArrayCollection $userRoles
     */
    protected $userRoles;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $enabled;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="last_login")
     */
    protected $lastLogin;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->enabled = true;
        $this->userRoles = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updated = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set plainPassword
     *
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * Get plainPassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set last login
     *
     * @param datetime $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * Get last login
     *
     * @return datetime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Returns the roles granted to the user.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        return $this->getUserRoles()->toArray();
    }

    public function getUserRoles()
    {
        return $this->userRoles;
    }

    /**
     *
     * @param Doctrine\Common\Collections\ArrayCollection $roles
     */
    public function setUserRoles(ArrayCollection $roles)
    {
        $this->userRoles = $roles;
    }

    /**
     * @param Madalynn\Bundle\MainBundle\Entity\Role $role
     */
    public function addUserRole(Role $role)
    {
        $this->userRoles->add($role);
    }

    /**
     * @param Madalynn\Bundle\MainBundle\Entity\Role $role
     */
    public function hasUserRole(Role $role)
    {
        return $this->userRoles->contains($role);
    }

    /**
     * @param string $role
     */
    public function hasRole($role)
    {
        foreach ($this->userRoles as $role) {
            if ($role == $role->getRole()) {
                return true;
            }
        }

        return false;
    }

    public function isAdmin()
    {
        return $this->hasRole('ROLE_ADMIN');
    }

    /**
     * @param Madalynn\Bundle\MainBundle\Entity\Role $role
     */
    public function removeUserRole(Role $role)
    {
        $this->userRoles->remove($role);
    }

    /**
     * Removes sensitive data from the user.
     *
     * @return void
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * {@inheritdoc}
     */
    public function equals(UserInterface $user)
    {
        return md5($user->getUsername()) == md5($this->getUsername());
    }

    /**
     * String representation
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getUsername();
    }

    /**
     * Bug in PHP P5.4 with the intern serialization
     *
     * @see https://github.com/symfony/symfony/issues/3691
     */
    public function serialize()
    {
        return json_encode(array(
            $this->id,
            $this->username,
            $this->email,
            $this->password,
            $this->salt,
            $this->userRoles,
            $this->enabled,
            $this->created,
            $this->updated,
            $this->lastLogin,
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->email,
            $this->password,
            $this->salt,
            $this->userRoles,
            $this->enabled,
            $this->created,
            $this->updated,
            $this->lastLogin,
        ) = json_decode($serialized, true);
    }
}
