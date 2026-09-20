<?php

namespace App\Http\Helpers;

use App\Models\Assignment;
use App\Models\BlogPost;
use App\Models\CaseStudy;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\Expense;
use App\Models\Experience;
use App\Models\Faq;
use App\Models\Meeting;
use App\Models\Payment;
use App\Models\Qualification;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Task;
use App\Models\Term;
use App\Models\Testimonial;

class AdminModuleCounts
{
    /**
     * @return array<string, int>
     */
    public static function all(): array
    {
        return [
            'admin.qualifications.index' => Qualification::count(),
            'admin.skills.index' => Skill::count(),
            'admin.experiences.index' => Experience::count(),
            'admin.services.index' => Service::count(),
            'admin.assignments.index' => Assignment::count(),
            'admin.case-studies.index' => CaseStudy::count(),
            'admin.testimonials.index' => Testimonial::count(),
            'admin.faqs.index' => Faq::count(),
            'admin.terms.index' => Term::count(),
            'admin.clients.index' => Client::count(),
            'admin.payments.index' => Payment::count(),
            'admin.expenses.index' => Expense::count(),
            'admin.meetings.index' => Meeting::count(),
            'admin.blog-posts.index' => BlogPost::count(),
            'admin.tasks.index' => Task::count(),
            'admin.messages.index' => ContactMessage::count(),
        ];
    }
}
