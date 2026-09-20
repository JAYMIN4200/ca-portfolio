<?php

namespace App\Http\Helpers;

class AdminPageTitle
{
    protected static array $titles = [
        'admin.dashboard' => 'Dashboard',
        'admin.profile.edit' => 'Profile',
        'admin.qualifications.index' => 'Qualifications',
        'admin.qualifications.create' => 'Add Qualification',
        'admin.qualifications.edit' => 'Edit Qualification',
        'admin.skills.index' => 'Skills',
        'admin.skills.create' => 'Add Skill',
        'admin.skills.edit' => 'Edit Skill',
        'admin.skill-categories.index' => 'Skill Categories',
        'admin.skill-categories.create' => 'Add Skill Category',
        'admin.skill-categories.edit' => 'Edit Skill Category',
        'admin.experiences.index' => 'Experience',
        'admin.experiences.create' => 'Add Experience',
        'admin.experiences.edit' => 'Edit Experience',
        'admin.services.index' => 'Services',
        'admin.services.create' => 'Add Service',
        'admin.services.edit' => 'Edit Service',
        'admin.assignments.index' => 'Assignments',
        'admin.assignments.create' => 'Add Assignment',
        'admin.assignments.edit' => 'Edit Assignment',
        'admin.tasks.index' => 'My Tasks',
        'admin.tasks.create' => 'Add Task',
        'admin.tasks.edit' => 'Edit Task',
        'admin.clients.index' => 'Clients',
        'admin.clients.create' => 'Add Client',
        'admin.clients.edit' => 'Edit Client',
        'admin.clients.show' => 'Client',
        'admin.payments.index' => 'Payments',
        'admin.payments.create' => 'Add Payment',
        'admin.payments.edit' => 'Edit Payment',
        'admin.meetings.index' => 'Meetings',
        'admin.meetings.create' => 'Add Meeting',
        'admin.meetings.edit' => 'Edit Meeting',
        'admin.case-studies.index' => 'Case Studies',
        'admin.case-studies.create' => 'Add Case Study',
        'admin.case-studies.edit' => 'Edit Case Study',
        'admin.blog-posts.index' => 'Blog Posts',
        'admin.blog-posts.create' => 'Add Blog Post',
        'admin.blog-posts.edit' => 'Edit Blog Post',
        'admin.testimonials.index' => 'Testimonials',
        'admin.testimonials.create' => 'Add Testimonial',
        'admin.testimonials.edit' => 'Edit Testimonial',
        'admin.faqs.index' => 'FAQs',
        'admin.faqs.create' => 'Add FAQ',
        'admin.faqs.edit' => 'Edit FAQ',
        'admin.terms.index' => 'Terms & Conditions',
        'admin.terms.create' => 'Add Term',
        'admin.terms.edit' => 'Edit Term',
        'admin.messages.index' => 'Contact Messages',
        'admin.messages.show' => 'Message',
        'admin.resume.index' => 'Resume',
        'admin.settings.index' => 'Settings',
    ];

    public static function for(?string $routeName): string
    {
        if (! $routeName) {
            return 'Dashboard';
        }

        return static::$titles[$routeName] ?? ucwords(str_replace(['admin.', '.index', '.'], ['', '', ' '], $routeName));
    }
}
