<?php

use App\Models\Education;
use App\Models\Eductaion;
use App\Models\Experience;
use App\Models\HomePage;
use App\Models\Order;
use App\Models\PersonalInformation;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\Project;
use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Spatie\Permission\Models\Role;

// الرئيسية
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('الرئيسية', route('dashboard'));
});

// الرئيسية > لوحة التحكم
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('لوحة التحكم', route('dashboard'));
});

// الرئيسية > لوحة التحكم > إدارة المستخدمين
Breadcrumbs::for('user-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('إدارة المستخدمين', route('user-management.users.index'));
});

// الرئيسية > لوحة التحكم > إدارة المستخدمين > المستخدمون
Breadcrumbs::for('user-management.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('المستخدمون', route('user-management.users.index'));
});

// الرئيسية > لوحة التحكم > إدارة المستخدمين > المستخدمون > [المستخدم]
Breadcrumbs::for('user-management.users.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('user-management.users.index');
    $trail->push(ucwords($user->name), route('user-management.users.show', $user));
});

// الرئيسية > لوحة التحكم > إدارة المستخدمين > الأدوار
Breadcrumbs::for('user-management.roles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('الأدوار', route('user-management.roles.index'));
});

// الرئيسية > لوحة التحكم > إدارة المستخدمين > الأدوار > [الدور]
Breadcrumbs::for('user-management.roles.show', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('user-management.roles.index');
    $trail->push(ucwords($role->name), route('user-management.roles.show', $role));
});

// الرئيسية > لوحة التحكم > إدارة المستخدمين > الصلاحيات
Breadcrumbs::for('user-management.permissions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('الصلاحيات', route('user-management.permissions.index'));
});

// الرئيسية > لوحة التحكم > إدارة الطلبات
Breadcrumbs::for('order-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('إدارة الطلبات', route('orders.index'));
});

// الرئيسية > لوحة التحكم > إدارة الطلبات > الطلبات
Breadcrumbs::for('order-management.orders.index', function (BreadcrumbTrail $trail) {
    $trail->parent('order-management.index');
    $trail->push('الطلبات', route('orders.index'));
});

// الرئيسية > لوحة التحكم > إدارة الطلبات > الطلبات > [الطلب]
Breadcrumbs::for('order-management.orders.show', function (BreadcrumbTrail $trail, Order $order) {
    $trail->parent('order-management.orders.index');
    $trail->push(ucwords($order->name), route('orders.show', $order));
});
