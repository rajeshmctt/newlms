<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faculties')->insert([
            [
                'first_name' => "Rajat",
                'last_name' => "Garg",
                'email' => 'rajat@coachtotransformation.com',
                'password' => Hash::make('123456Aa'),
                'description' => 'Rajat is a Master Certified Leadership coach with 20+ years of industry experience and over 2500 hours of coaching experience, helping people and organizations attain maximum effectiveness. His background includes working with CXOs, senior managers, managers and board of directors of small private companies to multi-billion dollar publicly traded organizations. He works with leadership teams of organizations and helps them become more accountable, take ownership and become more successful by focusing on ROI. He also works with teams to increase collaboration and teamwork, as the organization grows larger.

                Rajat runs a boutique leadership-coaching firm “Coach-To-Transformation” with offices in India, Malaysia, UK, Caribbean, Singapore, Bahrain, and UAE. He is a certified mentor coach and trains Leaders, HR professionals and future coaches in the art of coaching via a globally approved program by ICF. Rajat also sits on board as an advisor to a couple of startups as well provides mentorship to some startups.
                
                He has worked as Vice President for Accenture India and was leading their IT consulting and Cisco Partnership division while handling multi-million dollar accounts and P&L. He has consulted for large conglomerates and helped them achieve their agendas and outcomes. He has program managed and delivered large IT programs across the Globe and led large IT teams from diverse cultures and countries.
                
                He currently is the Chairperson, ICF Global Enterprise Board. He has engaged with ICF in multiple roles in the past, including sitting on the Independent Review Board of the International Coach Federation. He also served on the panel of Judges for the prestigious global ICF PRISM Award. He also sat on the Nomination Committee and runs an ICF Ethics COP for India.
                
                Rajat Is an Alum of INSEAD and IIT Bombay. Rajat is an avid reader of Fiction and has dabbled in theatre in the past. He currently lives in Mumbai, India.',
                'phone' => '(+91)997170-1403',
                'photo' => 'rajat.png',
                'status' => 'active',
            ],
            [
                'first_name' => "Sujata",
                'last_name' => "Barla",
                'email' => 'sujata@coachtotransformation.com',
                'password' => Hash::make('123456Aa'),
                'description' => 'Sujata is a Master Certified Leadership coach with 20+ years of industry experience and over 2500 hours of coaching experience, helping people and organizations attain maximum effectiveness.',
                'phone' => '(+91)989898-9898',
                'photo' => 'sujata.png',
                'status' => 'active',
            ],
            [
                'first_name' => "Arvind",
                'last_name' => "R",
                'email' => 'arvind@coachtotransformation.com',
                'password' => Hash::make('123456Aa'),
                'description' => 'Arvind Ramasundaram is a people person and has been a HR professional with 15 years of industry experience in various capacities as HR site leader, Sr. Manager and Business partner. He was associated with companies like Mphasis, Sungard, Symphony Technology Group and last with Intel Corporation before he quit to pursue his passion to become a certified professional coach. During his career in HR, he worked with various industry leaders which built him professionally and personally as a people focused individual. His career spanned various domains such as IT outsourcing, software services and product development companies. His business partnering expertise gave him opportunities to run coaching efforts in the organizations both 1x1 and group coaching basis. He has expertise of more than 1000+ hours of coaching conversations through such efforts across all levels. His career brought him unique opportunities of being in several M&As through his organizations which led him to part of the change management efforts by building coaching as a culture, vision and OD interventions for his business groups which won him several awards',
                'phone' => '(+91)897172-7000',
                'photo' => 'arvind.png',
                'status' => 'active',
            ],
            [
                'first_name' => "Ruchi",
                'last_name' => "Agrawal",
                'email' => 'ruchi@coachtotransformation.com',
                'password' => Hash::make('123456Aa'),
                'description' => '',
                'phone' => '',
                'photo' => 'ruchi.jpg',
                'status' => 'active',
            ],
            [
                'first_name' => "Philippe",
                'last_name' => "Rosinski",
                'email' => 'philippe@coachtotransformation.com',
                'password' => Hash::make('123456Aa'),
                'description' => 'Prof. Philippe Rosinski, MCC, is considered the pioneer of intercultural and global coaching. He is the author of two seminal books, Coaching Across Cultures and Global Coaching. For almost 30 years and across continents, Philippe has helped people and organizations thrive and make a positive difference in the world.

                Philippe is a world authority in executive coaching, team coaching, and global leadership development. He is the first European to have been designated Master Certified Coach by the International Coach Federation. He has also developed an integrative coaching supervision approach. 
                
                Philippe is the principal of Rosinski & Company, a consultancy based in Belgium with partners around the globe, and a professor at the Kenichi Ohmae Graduate School of Business in Tokyo, Japan. He intervenes in several other academic institutions including HEC Paris and the University of Cambridge. 
                
                He is the co-author of over 10 books including Evidence Based Coaching Handbook and Mastering Executive Coaching, and the author of the Cultural Orientations Framework (COF) assessment.
                
                A Master of Science from Stanford University, Philippe has received numerous awards including the Thinkers50 Marshall Goldsmith Leading Global Coaches Award (London, 2019). 
                ',
                'phone' => '',
                'photo' => 'PhilippeBW.jpg',
                'status' => 'active',
            ],
            [
                'first_name' => "Rekha",
                'last_name' => "R Upadhyay",
                'email' => 'rekha@coachtotransformation.com',
                'password' => Hash::make('123456Aa'),
                'description' => 'Rekha is an Executive Coach and HR Professional with 15 years of professional experience across industries in human resource function. As a Coach, she is passionate to support people across life ages seeking life transformation. She facilitates the journey of moving inwards, unfolding the discovery of self & being and empowering them to identify their true potential and take actions towards their future. She is Practical, Supportive, Direct and Authentic in her coaching style and weaves in her expertise of Conscious Business Coaching, NLP, Theory U, Systemic Coaching and Carl Roger’s- Being & Becoming of a person.

                As a certified coach with more than 200 hours of coaching, she continues to work with individuals and teams in areas of Executive, Leadership, Transitioning through Change and Careers, Performance, Life & Diversity leaders across management levels in organizations which includes both individual contributors and leaders managing small to larger teams across industries like Consulting, FMCG, Manufacturing, Engineering, Education, Technology, BFSI, Not-for-Profits’, Start-Ups etc to name a few.
                
                An Executive Program in Global Business Management from IIM Calcutta and Bachelors of Business Administration from Guru Gobind Singh Indraprastha University.
                 
                Currently she serves as a Board Member- Research & Publication vertical in the ICF Bengaluru Chapter. 
                
                Certified Credentials:
                •        Pursuing ICF- PCC 
                •        Conscious Business Coach -BetterUp (A program by Fred Kofman)
                •        ICF-ACC from International Coaching Federation
                •        NLP (Neuro Linguistic Programming)– Practitioner from Christ University
                •        Theory U Lab - Professor Dr. Otto Scharmer from MIT Sloan School of Management, Presencing Institute
                •        HOGAN Assessments- Practitioner & Coach
                •        Competency Based Interviewing Skills
                •        CPI Career Transition Consultant',
                'phone' => '',
                'photo' => 'Rekha-Upadhyay.jpg',
                'status' => 'active',
            ],
            [
                'first_name' => "Ave",
                'last_name' => "Peetri",
                'email' => 'ave@coachtotransformation.com',
                'password' => Hash::make('123456Aa'),
                'description' => 'Ave Peetri has been a corporate executive working for The Coca-Cola Company and other international and local companies across USA and Europe. She has also created 2 of her own, one a consulting company and the other an e-commerce startup that was sold to a competitor. Experiencing the fast-paced life of executives and seeing the decisions that are made in top positions started her passion for developing leadership and working with entrepreneurs, executives, and teams. 

                In 2013, Ave started her own coaching company in Canada, coaching entrepreneurs on how to grow their business and develop themselves as leaders. Ave is a graduate of CTI Co-Active Coaching and Leadership course. She was credentialed as the Professional Certified Coach (PCC) by International Coach Federation in 2017 and acquired the Certificate in Systemic Team Coaching in 2018.
                
                Ave has been based in Oman since 2016, where she is working as an Executive and Team Coach and is volunteering as the President of ICF Oman Chapter. The company where she worked with individuals and teams of senior leaders received an Honorary Mention on the 2020 ICF Middle East Prism Award. The first company and coach in Oman to receive this honor. ',
                'phone' => '',
                'photo' => 'AveBW.jpg',
                'status' => 'active',
            ],
            [
                'first_name' => "Gregory",
                'last_name' => "Rastello",
                'email' => 'gregory@coachtotransformation.com',
                'password' => Hash::make('123456Aa'),
                'description' => 'Gregory is a family and organizational systemic constellations facilitator. Gregory designs and delivers programs for participants to develop their systemic leadership and to take the systemic intelligence back to their everyday life and work. 

                Gregory believes that people and organizations thrive sustainably by developing harmonious relationships within their ecosystem.
                
                Before launching his own practice, Gregory was holding managing roles in MNCs and SMEs as well as HR & leadership development consulting companies. Originally from France, Gregory has a deep understanding of Asian working environments from my 23-year working experience in China and Southeast Asia.
                
                Gregory started his systemic learning journey in 2004. He completed his systemic constellations studies at Hellinger France, Hellinger Taiwan and TAOS Institute, among others. He also works with COF Assessment (Cultural Orientations Framework), TCI Team Diagnostic, Hogan Assessment, MBTI, Action Learning Coaching and Co-active Coaching. He holds the ACC credential issued by the ICF.
                ',
                'phone' => '',
                'photo' => 'Gregorybw.jpg',
                'status' => 'active',
            ],
        ]);
    }
}
