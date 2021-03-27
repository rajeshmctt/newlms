<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ElectiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('electives')->insert([
            [
                'agreement_id' => 3,
                'label_id' => 1,
                'code' => "EL01",
                'name' => "Introduction to Systemic Constellations",
                'description' => 'We humans are part of many different relationship systems: families, religious and social communities, organizations, societies… We are impacted by our belonging to these systems, which results in our lives being expanded or limited, with or without us realising it. 

                Systemic constellations are a way of working with the issues originated from these relationship systems. They allow to identify and transform the dynamics of these systems that are usually difficult to understand and change. Systemic constellations also develop our ability to tap into a source of information that we often neglect: our body and our right brain.
                ',
                'long_description' => 'We humans are part of many different relationship systems: families, religious and social communities, organizations, societies. We are impacted by our belonging to these systems, which results in our lives being expanded or limited, with or without us realising it. 

                Systemic constellations are a way of working with the issues originated from these relationship systems. They allow to identify and transform the dynamics of these systems that are usually difficult to understand and change. Systemic constellations also develop our ability to tap into a source of information that we often neglect: our body and our right brain.
                
                During this experiential session, you will receive an introduction to relationship systems and the systemic constellations methodology. You will get familiar with the systemic forces that apply to relationship systems and you will experience systemic activities that you will be able to use for you and your coaching. You will also reconnect with your own system and be able to develop the inner attitude required to work from a systemic perspective.',
                'image' => 'default.png',
                'status' => 'active',
            ],
            [
                'agreement_id' => 3,
                'label_id' => 1,
                'code' => "EL02",
                'name' => "Coach Knowledge Assessment",
                'description' => '',
                'long_description' => '',
                'image' => 'default.png',
                'status' => 'active',
            ],
            [
                'agreement_id' => 3,
                'label_id' => 1,
                'code' => "EL03",
                'name' => "Developing Coaching Culture within your organizations",
                'description' => '',
                'long_description' => '',
                'image' => 'default.png',
                'status' => 'active',
            ],
            [
                'agreement_id' => 3,
                'label_id' => 1,
                'code' => "EL04",
                'name' => "Systemic Team Coaching Introduction",
                'description' => 'We will explore how does Systemic Team Coaching differ from individual coaching, team building, facilitation, and other forms of team coaching. What are the benefits of coaching a team from systemic point of view and what does that really mean?
                We will also look into research and case studies and have some fun practicing being a team coach. 
                ',
                'long_description' => 'We will explore how does Systemic Team Coaching differ from individual coaching, team building, facilitation, and other forms of team coaching. What are the benefits of coaching a team from systemic point of view and what does that really mean?

                We will also look into research and case studies and have some fun practicing being a team coach. ',
                'image' => 'default.png',
                'status' => 'active',
            ],
            [
                'agreement_id' => 3,
                'label_id' => 1,
                'code' => "EL05",
                'name' => "Coaching Across Cultures",
                'description' => 'Cultural differences of all kinds are often a source of misunderstandings and frustrations. In this session, Prof. Philippe Rosinski will show how coaches can improve their creativity and impact by treating cultural differences as a source of richness and as an opportunity to go beyond current cultural limitations. You will learn about a broad, inclusive and dynamic concept of culture that contrasts with the traditional static and binary view (which tends to perpetuate limiting stereotypes). ',
                'long_description' => 'Cultural differences of all kinds are often a source of misunderstandings and frustrations. In this session, Prof. Philippe Rosinski will show how coaches can improve their creativity and impact by treating cultural differences as a source of richness and as an opportunity to go beyond current cultural limitations. You will learn about a broad, inclusive and dynamic concept of culture that contrasts with the traditional static and binary view (which tends to perpetuate limiting stereotypes).

                You will discover how the Cultural Orientations Framework (COF) assessment -a roadmap and assessment tool to navigate the cultural terrain- can bring your individual and team coaching to the next level.
                
                You will have an opportunity to experience first-hand the COF assessment, to examine both your individual and collective results, celebrating strengths and uncovering developmental avenues.  
                
                Takeaways:
                •             Learn how to release higher creativity, achieve greater impact, as well as promote unity by making the most of alternative cultural perspectives;
                •             Discover how to go beyond current cultural norms, values, and beliefs (and stereotypes) when working with people; 
                •             Acquire a vocabulary to describe salient cultural characteristics; 
                •             Experience first-hand the Cultural Orientations Framework (COF) assessment and discover how the tool can be used to promote individual, team and organizational development.
                ',
                'image' => 'default.png',
                'status' => 'active',
            ],
            [
                'agreement_id' => 3,
                'label_id' => 1,
                'code' => "EL06",
                'name' => "Application of NLP in Coaching",
                'description' => 'Neuro Linguistic Programming (NLP) is how we think, sense, feel, say and behave. A science of what going within the brain, nervous system and stimulus and an art of how the body & mind responds in the form of human behavior. Human behavior is as complex as our body. NLP beautifully helps people to discover themselves at conscious, unconscious and sub-conscious levels',
                'long_description' => 'Neuro Linguistic Programming (NLP) is how we think, sense, feel, say and behave. A science of what going within the brain, nervous system and stimulus and an art of how the body & mind responds in the form of human behavior. Human behavior is as complex as our body. NLP beautifully helps people to discover themselves at conscious, unconscious and sub-conscious levels. 

                What would one learn?
                Fundamentals of NLP, the science behind it. Neuroscience aspect of the human brain. Communication within the brain and the relationships between thoughts, patterns and behaviors. Understanding on how environment, our senses, beliefs & values work within us and how can one make a conscious choice by creating deeper awareness. NLP helps coaches in a big way to understand a client’s map of their world, thought patterns, beliefs, values, behaviors and when we work with clients, as coaches how we can support them to bring their unconscious to awareness; helping them notice how they communicate, what they are experiencing, limiting beliefs and their idea of what’s possible. It is an evidence- based approach towards coaching.
                
                Practical applicability of one of the tools. In-depth understanding on mental models, behaviors, perspectives. Why and how does NLP work? When to use and not to use?',
                'image' => 'default.png',
                'status' => 'active',
            ],
        ]);

        DB::table('elective_faculty')->insert([
            [
                'elective_id' => 1,
                'faculty_id' => 35,
            ],
            [
                'elective_id' => 2,
                'faculty_id' => 35,
            ],
            [
                'elective_id' => 3,
                'faculty_id' => 35,
            ],
            [
                'elective_id' => 4,
                'faculty_id' => 35,
            ],
            [
                'elective_id' => 5,
                'faculty_id' => 35,
            ],
            [
                'elective_id' => 6,
                'faculty_id' => 35,
            ],
        ]);

        // DB::table('program_elective')->insert([
        //     [
        //         'program_id' => 1,
        //         'elective_id' => 1,
        //     ],
        //     [
        //         'program_id' => 1,
        //         'elective_id' => 2,
        //     ],
        //     [
        //         'program_id' => 1,
        //         'elective_id' => 3,
        //     ],
        //     [
        //         'program_id' => 1,
        //         'elective_id' => 4,
        //     ],
        //     [
        //         'program_id' => 1,
        //         'elective_id' => 5,
        //     ],
        //     [
        //         'program_id' => 1,
        //         'elective_id' => 6,
        //     ],
        //     [
        //         'program_id' => 2,
        //         'elective_id' => 1,
        //     ],
        //     [
        //         'program_id' => 2,
        //         'elective_id' => 2,
        //     ],
        //     [
        //         'program_id' => 2,
        //         'elective_id' => 3,
        //     ],
        //     [
        //         'program_id' => 2,
        //         'elective_id' => 4,
        //     ],
        //     [
        //         'program_id' => 2,
        //         'elective_id' => 5,
        //     ],
        //     [
        //         'program_id' => 2,
        //         'elective_id' => 6,
        //     ],
        //     [
        //         'program_id' => 3,
        //         'elective_id' => 1,
        //     ],
        //     [
        //         'program_id' => 3,
        //         'elective_id' => 2,
        //     ],
        //     [
        //         'program_id' => 3,
        //         'elective_id' => 3,
        //     ],
        //     [
        //         'program_id' => 3,
        //         'elective_id' => 4,
        //     ],
        //     [
        //         'program_id' => 3,
        //         'elective_id' => 5,
        //     ],
        //     [
        //         'program_id' => 3,
        //         'elective_id' => 6,
        //     ],
        //     [
        //         'program_id' => 4,
        //         'elective_id' => 1,
        //     ],
        //     [
        //         'program_id' => 4,
        //         'elective_id' => 2,
        //     ],
        //     [
        //         'program_id' => 4,
        //         'elective_id' => 3,
        //     ],
        //     [
        //         'program_id' => 4,
        //         'elective_id' => 4,
        //     ],
        //     [
        //         'program_id' => 4,
        //         'elective_id' => 5,
        //     ],
        //     [
        //         'program_id' => 4,
        //         'elective_id' => 6,
        //     ],
        //     [
        //         'program_id' => 5,
        //         'elective_id' => 1,
        //     ],
        //     [
        //         'program_id' => 5,
        //         'elective_id' => 2,
        //     ],
        //     [
        //         'program_id' => 5,
        //         'elective_id' => 3,
        //     ],
        //     [
        //         'program_id' => 5,
        //         'elective_id' => 4,
        //     ],
        //     [
        //         'program_id' => 5,
        //         'elective_id' => 5,
        //     ],
        //     [
        //         'program_id' => 5,
        //         'elective_id' => 6,
        //     ],
        // ]);
    }
}
