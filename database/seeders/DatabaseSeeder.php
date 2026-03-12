<?php

namespace Database\Seeders;

use App\Models\EventItem;
use App\Models\GalleryItem;
use App\Models\LiveScore;
use App\Models\ManagementMember;
use App\Models\News;
use App\Models\PlayerProfile;
use App\Models\PlayerValue;
use App\Models\RegistrationApplication;
use App\Models\ScoutingProgram;
use App\Models\TransferItem;
use App\Models\User;
use App\Models\VideoClip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password'), 'is_admin' => true]
        );

        $articles = [
            [
                'title' => 'Open Trials Schedule Released for April 2026',
                'slug' => 'open-trials-schedule-released-april-2026',
                'excerpt' => 'Abuja Kings Football Academy has released official dates for the next open trial sessions.',
                'content' => "Abuja Kings Football Academy has released official dates for the next open trial sessions.\n\nSelected players will move into an evaluation cycle that includes technical drills, tactical assessments, and fitness testing.",
                'cover_image' => 'demo/news-1.svg',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'U17 Development Squad Wins Friendly 3-1',
                'slug' => 'u17-development-squad-wins-friendly-3-1',
                'excerpt' => 'The U17 squad delivered a strong performance with improved pressing and compact shape.',
                'content' => "The U17 squad delivered a strong performance with improved pressing and compact shape.\n\nCoaches commended the team for discipline and decision-making across both halves.",
                'cover_image' => 'demo/news-2.svg',
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'New Weekly Mentorship Sessions Introduced',
                'slug' => 'new-weekly-mentorship-sessions-introduced',
                'excerpt' => 'The academy adds weekly mentorship sessions focused on leadership, mindset, and discipline.',
                'content' => "The academy has introduced weekly mentorship sessions focused on leadership, mindset, and discipline.\n\nThese sessions are designed to support holistic growth on and off the pitch.",
                'cover_image' => 'demo/news-3.svg',
                'is_published' => true,
                'published_at' => now()->subDays(14),
            ],
        ];

        foreach ($articles as $article) {
            News::query()->updateOrCreate(
                ['slug' => $article['slug']],
                $article
            );
        }

        $gallerySeed = [
            [
                'title' => 'Morning Technical Session',
                'slug' => 'morning-technical-session',
                'category' => 'Training',
                'description' => 'Close-control and quick-passing drills during the morning development block.',
                'image_path' => 'demo/gallery-1.svg',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
                'captured_at' => now()->subDays(3)->toDateString(),
            ],
            [
                'title' => 'U17 Friendly Matchday',
                'slug' => 'u17-friendly-matchday',
                'category' => 'Matchday',
                'description' => 'U17 squad in action during a development friendly fixture.',
                'image_path' => 'demo/gallery-2.svg',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
                'captured_at' => now()->subDays(6)->toDateString(),
            ],
            [
                'title' => 'Strength and Conditioning Circuit',
                'slug' => 'strength-and-conditioning-circuit',
                'category' => 'Fitness',
                'description' => 'Players improving power and endurance under coaching supervision.',
                'image_path' => 'demo/gallery-3.svg',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 3,
                'captured_at' => now()->subDays(8)->toDateString(),
            ],
        ];

        foreach ($gallerySeed as $item) {
            GalleryItem::query()->updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }

        $eventsSeed = [
            [
                'title' => 'U16 League Match vs Pinnacle FC',
                'slug' => 'u16-league-match-vs-pinnacle-fc',
                'event_type' => 'Matchday',
                'venue' => 'Kings Stadium, Abuja',
                'summary' => 'Competitive development fixture for the U16 squad.',
                'description' => "The U16 squad will play Pinnacle FC in a structured league fixture.\n\nFocus areas include defensive shape, ball progression, and finishing in transitions.",
                'starts_at' => now()->addDays(4)->setTime(15, 30),
                'ends_at' => now()->addDays(4)->setTime(17, 30),
                'registration_link' => null,
                'featured_image' => 'demo/event-1.svg',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Monthly Open Trials',
                'slug' => 'monthly-open-trials',
                'event_type' => 'Trials',
                'venue' => 'Academy Complex, Abuja',
                'summary' => 'Open trial event for identified youth talents.',
                'description' => "Open trials for U15 and U17 categories.\n\nParticipants will be assessed on technical quality, decision-making, and physical readiness.",
                'starts_at' => now()->addDays(9)->setTime(9, 0),
                'ends_at' => now()->addDays(9)->setTime(13, 0),
                'registration_link' => 'https://www.kingsfootballacademyabuja.com',
                'featured_image' => 'demo/event-2.svg',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Senior Squad Conditioning Session',
                'slug' => 'senior-squad-conditioning-session',
                'event_type' => 'Training',
                'venue' => 'Training Ground A',
                'summary' => 'Intensive conditioning session for senior academy players.',
                'description' => "Strength and conditioning drills with workload management.\n\nSession includes movement screening and sprint mechanics.",
                'starts_at' => now()->subDays(6)->setTime(17, 0),
                'ends_at' => now()->subDays(6)->setTime(19, 0),
                'registration_link' => null,
                'featured_image' => 'demo/event-3.svg',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($eventsSeed as $item) {
            EventItem::query()->updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }

        $transferSeed = [
            [
                'title' => 'Akande Joins Kings Senior Squad',
                'slug' => 'akande-joins-kings-senior-squad',
                'player_name' => 'Daniel Akande',
                'position' => 'Forward',
                'transfer_type' => 'incoming',
                'from_club' => 'FCT Youth Select',
                'to_club' => 'Abuja Kings Football Academy',
                'transfer_fee' => 'Development contract',
                'player_image' => 'demo/transfer-1.svg',
                'contract_until' => now()->addYears(2)->toDateString(),
                'summary' => 'Akande joins after strong trial metrics and consistent finishing output.',
                'details' => "Daniel Akande has completed his move into the senior development group.\n\nHe will continue position-specific finishing and tactical transition work with the attacking unit.",
                'announced_at' => now()->subDays(4),
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Ibrahim Moves on Loan for Match Minutes',
                'slug' => 'ibrahim-moves-on-loan-for-match-minutes',
                'player_name' => 'Sani Ibrahim',
                'position' => 'Central Midfielder',
                'transfer_type' => 'outgoing',
                'from_club' => 'Abuja Kings Football Academy',
                'to_club' => 'Nile Stars FC',
                'transfer_fee' => 'Loan',
                'player_image' => 'demo/transfer-2.svg',
                'contract_until' => now()->addMonths(10)->toDateString(),
                'summary' => 'Short-term loan agreed to accelerate competitive exposure and match rhythm.',
                'details' => "Sani Ibrahim will spend the season with Nile Stars FC on loan.\n\nThe move includes a development monitoring framework with monthly performance review checkpoints.",
                'announced_at' => now()->subDays(9),
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Open Trial Signing Window Announced',
                'slug' => 'open-trial-signing-window-announced',
                'player_name' => 'Multiple Prospects',
                'position' => null,
                'transfer_type' => 'trial',
                'from_club' => null,
                'to_club' => 'Abuja Kings Football Academy',
                'transfer_fee' => 'N/A',
                'player_image' => 'demo/transfer-3.svg',
                'contract_until' => null,
                'summary' => 'The academy opens a selective trial window for U16-U19 categories.',
                'details' => "Selected players from scouting events will enter a structured evaluation phase.\n\nFinal intake decisions will follow technical, tactical, and character reviews.",
                'announced_at' => now()->subDays(2),
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($transferSeed as $item) {
            TransferItem::query()->updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }

        $playersSeed = [
            [
                'full_name' => 'Emeka Okoro',
                'slug' => 'emeka-okoro',
                'jersey_number' => 9,
                'date_of_birth' => '2008-07-14',
                'nationality' => 'Nigerian',
                'preferred_foot' => 'Right',
                'primary_position' => 'Forward',
                'secondary_position' => 'Winger',
                'height_cm' => 176,
                'weight_kg' => 70,
                'current_team' => 'Abuja Kings Football Academy',
                'video_url' => 'https://youtube.com/@kingsfootballacademyabuja',
                'summary' => 'Quick forward with strong finishing and movement in behind.',
                'bio' => "Emeka is a high-intensity attacker focused on timing runs and pressing from the front.\n\nHe has shown strong progression in off-ball positioning.",
                'strengths' => "Finishing under pressure\nAcceleration in transition\nAggressive pressing",
                'achievements' => "Top scorer in internal academy tournament\nSelected for regional youth showcase",
                'profile_image' => 'demo/player-1.svg',
                'cv_document' => null,
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'full_name' => 'Musa Abdullahi',
                'slug' => 'musa-abdullahi',
                'jersey_number' => 6,
                'date_of_birth' => '2007-11-03',
                'nationality' => 'Nigerian',
                'preferred_foot' => 'Left',
                'primary_position' => 'Defensive Midfielder',
                'secondary_position' => 'Central Midfielder',
                'height_cm' => 181,
                'weight_kg' => 74,
                'current_team' => 'Abuja Kings Football Academy',
                'video_url' => null,
                'summary' => 'Composed midfielder with strong game reading and ball retention.',
                'bio' => "Musa controls tempo in midfield and supports build-up play through short and progressive passing.\n\nHe regularly leads communication in defensive transitions.",
                'strengths' => "Positioning and interceptions\nProgressive passing\nDefensive duels",
                'achievements' => "Captain in youth development fixtures\nBest tactical discipline award",
                'profile_image' => 'demo/player-2.svg',
                'cv_document' => null,
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'full_name' => 'Chinedu Eze',
                'slug' => 'chinedu-eze',
                'jersey_number' => 3,
                'date_of_birth' => '2008-02-22',
                'nationality' => 'Nigerian',
                'preferred_foot' => 'Both',
                'primary_position' => 'Center Back',
                'secondary_position' => 'Right Back',
                'height_cm' => 183,
                'weight_kg' => 76,
                'current_team' => 'Abuja Kings Football Academy',
                'video_url' => null,
                'summary' => 'Physically strong defender with clean tackling and aerial presence.',
                'bio' => "Chinedu plays as a proactive defender and thrives in one-on-one situations.\n\nHe contributes to defensive organization and set-piece threat.",
                'strengths' => "Aerial duels\nRecovery pace\nBall-winning tackles",
                'achievements' => "Most clean sheets in U17 cycle\nDefensive player of the month",
                'profile_image' => 'demo/player-3.svg',
                'cv_document' => null,
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($playersSeed as $item) {
            PlayerProfile::query()->updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }

        $emekaProfile = PlayerProfile::query()->where('slug', 'emeka-okoro')->first();
        $musaProfile = PlayerProfile::query()->where('slug', 'musa-abdullahi')->first();
        $chineduProfile = PlayerProfile::query()->where('slug', 'chinedu-eze')->first();

        $playerValuesSeed = [
            [
                'player_profile_id' => $emekaProfile?->id,
                'player_name_snapshot' => 'Emeka Okoro',
                'slug' => 'emeka-okoro-value-assessment',
                'value_ngn' => 42000000,
                'previous_value_ngn' => 36000000,
                'value_change' => 'increase',
                'player_image' => 'demo/player-1.svg',
                'assessment_note' => "Value increased due to improved finishing conversion and consistent match impact.\n\nPerformance trend shows stronger decision-making in final-third situations.",
                'assessed_at' => now()->subDays(4)->toDateString(),
                'assessor_name' => 'Technical Analysis Team',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'player_profile_id' => $musaProfile?->id,
                'player_name_snapshot' => 'Musa Abdullahi',
                'slug' => 'musa-abdullahi-value-assessment',
                'value_ngn' => 38500000,
                'previous_value_ngn' => 39500000,
                'value_change' => 'decrease',
                'player_image' => 'demo/player-2.svg',
                'assessment_note' => "Minor decrease based on recent availability and reduced match rhythm.\n\nTechnical quality remains high with expected rebound after full match return.",
                'assessed_at' => now()->subDays(7)->toDateString(),
                'assessor_name' => 'Player Pathway Unit',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'player_profile_id' => $chineduProfile?->id,
                'player_name_snapshot' => 'Chinedu Eze',
                'slug' => 'chinedu-eze-value-assessment',
                'value_ngn' => 31000000,
                'previous_value_ngn' => 31000000,
                'value_change' => 'stable',
                'player_image' => 'demo/player-3.svg',
                'assessment_note' => "Stable valuation reflecting consistent defensive output and tactical discipline.\n\nCurrent trajectory remains positive with room for increase on exposure events.",
                'assessed_at' => now()->subDays(10)->toDateString(),
                'assessor_name' => 'Scouting and Development Team',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($playerValuesSeed as $item) {
            PlayerValue::query()->updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }

        $managementSeed = [
            [
                'full_name' => 'Coach Ibrahim Lawal',
                'slug' => 'coach-ibrahim-lawal',
                'role_title' => 'Head Coach',
                'department' => 'Technical',
                'email' => null,
                'phone' => '+2348033279762',
                'bio' => "Coach Ibrahim leads the academy technical direction and player development structure.\n\nHe oversees training plans, tactical frameworks, and pathway progression.",
                'image_path' => 'demo/management-1.svg',
                'experience_years' => 12,
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'full_name' => 'Amina Bello',
                'slug' => 'amina-bello',
                'role_title' => 'Operations Manager',
                'department' => 'Management',
                'email' => null,
                'phone' => null,
                'bio' => "Amina coordinates academy operations, event logistics, and program administration.\n\nShe ensures smooth day-to-day delivery across all player groups.",
                'image_path' => 'demo/management-2.svg',
                'experience_years' => 8,
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'full_name' => 'Dr. Chukwuemeka Obi',
                'slug' => 'dr-chukwuemeka-obi',
                'role_title' => 'Sports Performance Lead',
                'department' => 'Medical & Performance',
                'email' => null,
                'phone' => null,
                'bio' => "Dr. Obi supports injury prevention, conditioning standards, and player wellness protocols.\n\nHe works with coaches to align physical output with match demands.",
                'image_path' => 'demo/management-3.svg',
                'experience_years' => 10,
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($managementSeed as $item) {
            ManagementMember::query()->updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }

        $liveScoresSeed = [
            [
                'title' => 'Abuja Kings U17 vs Pinnacle FC U17',
                'slug' => 'abuja-kings-u17-vs-pinnacle-fc-u17',
                'competition' => 'Youth Development League',
                'home_team' => 'Abuja Kings U17',
                'home_logo' => 'demo/club-kings.svg',
                'away_team' => 'Pinnacle FC U17',
                'away_logo' => 'demo/club-pinnacle.svg',
                'venue' => 'Kings Training Ground',
                'kickoff_at' => now()->setTime(15, 0),
                'home_score' => 2,
                'away_score' => 1,
                'match_status' => 'live',
                'live_minute' => 73,
                'match_report' => "Kings U17 are controlling transitions and creating high-quality chances from wide overloads.\n\nThe current lead comes from sustained pressure and compact midfield recovery.",
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Abuja Kings Senior vs Nile Stars',
                'slug' => 'abuja-kings-senior-vs-nile-stars',
                'competition' => 'Friendly Match',
                'home_team' => 'Abuja Kings Senior',
                'home_logo' => 'demo/club-kings.svg',
                'away_team' => 'Nile Stars',
                'away_logo' => 'demo/club-nile.svg',
                'venue' => 'Kings Stadium, Abuja',
                'kickoff_at' => now()->addDays(2)->setTime(16, 0),
                'home_score' => null,
                'away_score' => null,
                'match_status' => 'upcoming',
                'live_minute' => null,
                'match_report' => "Upcoming friendly fixture to test tactical cohesion and squad depth.",
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Abuja Kings U16 vs Capital City Academy',
                'slug' => 'abuja-kings-u16-vs-capital-city-academy',
                'competition' => 'Regional Youth Cup',
                'home_team' => 'Abuja Kings U16',
                'home_logo' => 'demo/club-kings.svg',
                'away_team' => 'Capital City Academy',
                'away_logo' => 'demo/club-capital.svg',
                'venue' => 'FCT Sports Arena',
                'kickoff_at' => now()->subDays(4)->setTime(14, 0),
                'home_score' => 3,
                'away_score' => 2,
                'match_status' => 'completed',
                'live_minute' => null,
                'match_report' => "Completed match with strong second-half adjustments and improved defensive organization.\n\nKings secured the result with a late set-piece goal.",
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($liveScoresSeed as $item) {
            LiveScore::query()->updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }

        $registrationsSeed = [
            [
                'reference_code' => 'AKFA-DEMO-001',
                'full_name' => 'Samuel Adeyemi',
                'date_of_birth' => '2010-05-18',
                'guardian_name' => 'Mr. Adeyemi',
                'phone' => '+2348012345678',
                'email' => 'samuel.adeyemi@example.com',
                'address' => 'Wuse 2, Abuja',
                'age_group' => 'U14-U16',
                'preferred_position' => 'Forward',
                'preferred_foot' => 'Right',
                'experience_level' => 'Intermediate',
                'medical_notes' => null,
                'additional_notes' => 'Available for weekend sessions.',
                'status' => 'reviewing',
                'review_notes' => 'Invite for next open trial block.',
                'submitted_at' => now()->subDays(2),
                'contacted_at' => null,
            ],
            [
                'reference_code' => 'AKFA-DEMO-002',
                'full_name' => 'Mariam Yakubu',
                'date_of_birth' => '2011-01-27',
                'guardian_name' => 'Mrs. Yakubu',
                'phone' => '+2348098765432',
                'email' => null,
                'address' => 'Gwarinpa, Abuja',
                'age_group' => 'U11-U13',
                'preferred_position' => 'Midfielder',
                'preferred_foot' => 'Left',
                'experience_level' => 'Beginner',
                'medical_notes' => null,
                'additional_notes' => null,
                'status' => 'new',
                'review_notes' => null,
                'submitted_at' => now()->subDay(),
                'contacted_at' => null,
            ],
            [
                'reference_code' => 'AKFA-DEMO-003',
                'full_name' => 'Chukwu Nwosu',
                'date_of_birth' => '2008-10-09',
                'guardian_name' => null,
                'phone' => '+2348031112222',
                'email' => 'chukwu.nwosu@example.com',
                'address' => 'Kubwa, Abuja',
                'age_group' => 'U17-U20',
                'preferred_position' => 'Center Back',
                'preferred_foot' => 'Both',
                'experience_level' => 'Competitive',
                'medical_notes' => 'Recovered from minor ankle strain.',
                'additional_notes' => 'Can attend weekday evening training.',
                'status' => 'accepted',
                'review_notes' => 'Accepted into advanced development cycle.',
                'submitted_at' => now()->subDays(7),
                'contacted_at' => now()->subDays(5),
            ],
        ];

        foreach ($registrationsSeed as $item) {
            RegistrationApplication::query()->updateOrCreate(
                ['reference_code' => $item['reference_code']],
                $item
            );
        }

        $videosSeed = [
            [
                'title' => 'U17 Match Highlights vs Pinnacle FC',
                'slug' => 'u17-match-highlights-vs-pinnacle-fc',
                'category' => 'Matchday',
                'source_url' => 'https://youtube.com/@kingsfootballacademyabuja',
                'thumbnail_url' => '/storage/demo/video-1.svg',
                'duration_seconds' => 318,
                'recorded_at' => now()->subDays(5)->toDateString(),
                'description' => "Highlights from the U17 fixture against Pinnacle FC.\n\nFocus sequences include pressing triggers, final-third combinations, and defensive recovery runs.",
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Speed and Agility Training Circuit',
                'slug' => 'speed-and-agility-training-circuit',
                'category' => 'Training',
                'source_url' => 'https://www.tiktok.com/@kingsfootballacademy',
                'thumbnail_url' => '/storage/demo/video-2.svg',
                'duration_seconds' => 146,
                'recorded_at' => now()->subDays(9)->toDateString(),
                'description' => "Players complete multi-phase speed and agility drills under coaching supervision.\n\nThe session emphasizes acceleration mechanics and directional control.",
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Goalkeeper Reaction Drill Session',
                'slug' => 'goalkeeper-reaction-drill-session',
                'category' => 'Training',
                'source_url' => 'https://www.instagram.com/kingsfootballacademyabuja',
                'thumbnail_url' => '/storage/demo/video-3.svg',
                'duration_seconds' => 204,
                'recorded_at' => now()->subDays(13)->toDateString(),
                'description' => "Short clip from a goalkeeper-specific reaction and handling session.\n\nWork includes close-range reflex saves and distribution patterns.",
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($videosSeed as $item) {
            VideoClip::query()->updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }

        $programsSeed = [
            [
                'title' => 'Youth Foundation Program',
                'slug' => 'youth-foundation-program',
                'age_group' => 'U8-U12',
                'schedule' => 'Monday, Wednesday, Friday • 4:00 PM',
                'duration_weeks' => 12,
                'capacity' => 40,
                'registration_link' => 'https://www.kingsfootballacademyabuja.com',
                'featured_image' => 'demo/program-1.svg',
                'fee' => 'Contact academy',
                'description' => 'A structured foundational program focused on ball mastery, game awareness, and teamwork.',
                'highlights' => "Three technical sessions weekly\nFriendly development matches\nCharacter and leadership workshops",
                'requirements' => "Basic fitness for age level\nParent/guardian consent\nCommitment to schedule",
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Competitive Development Program',
                'slug' => 'competitive-development-program',
                'age_group' => 'U13-U18',
                'schedule' => 'Tuesday, Thursday, Saturday • 5:00 PM',
                'duration_weeks' => 16,
                'capacity' => 36,
                'registration_link' => 'https://www.kingsfootballacademyabuja.com',
                'featured_image' => 'demo/program-2.svg',
                'fee' => 'Assessment based',
                'description' => 'Advanced tactical and physical development program for competitive players.',
                'highlights' => "High-intensity tactical sessions\nPerformance tracking and analysis\nLeague and showcase opportunities",
                'requirements' => "Intermediate technical level\nFitness test participation\nConsistent attendance",
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Monthly Open Trials Program',
                'slug' => 'monthly-open-trials-program',
                'age_group' => 'U15-U20',
                'schedule' => 'First Saturday of each month • 9:00 AM',
                'duration_weeks' => null,
                'capacity' => 120,
                'registration_link' => 'https://www.kingsfootballacademyabuja.com',
                'featured_image' => 'demo/program-3.svg',
                'fee' => 'Free trial',
                'description' => 'Open scouting trials designed to identify high-potential players for academy pathways.',
                'highlights' => "Scout-led assessment sessions\nPosition-based evaluation\nFeedback and next-step recommendations",
                'requirements' => "Valid registration details\nSportswear and boots\nEarly arrival for accreditation",
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($programsSeed as $item) {
            ScoutingProgram::query()->updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}
