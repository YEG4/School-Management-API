<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $courses = [
            ['title' => 'Mathematics 101', 'description' => 'Introduction to basic algebra, geometry, and arithmetic concepts.', 'code' => 'MATH101'],
            ['title' => 'Advanced Calculus', 'description' => 'Study of limits, derivatives, integrals, and infinite series.', 'code' => 'MATH201'],
            ['title' => 'Linear Algebra', 'description' => 'Vector spaces, matrices, linear transformations, and eigenvalues.', 'code' => 'MATH250'],
            ['title' => 'Physics I', 'description' => 'Mechanics, motion, forces, and energy principles.', 'code' => 'PHYS101'],
            ['title' => 'Physics II', 'description' => 'Electromagnetism, waves, and thermodynamics.', 'code' => 'PHYS102'],
            ['title' => 'Chemistry Fundamentals', 'description' => 'Atomic structure, chemical bonding, and reactions.', 'code' => 'CHEM101'],
            ['title' => 'Organic Chemistry', 'description' => 'Study of carbon compounds and organic reactions.', 'code' => 'CHEM201'],
            ['title' => 'Biology Basics', 'description' => 'Cell biology, genetics, evolution, and ecology.', 'code' => 'BIO101'],
            ['title' => 'Human Anatomy', 'description' => 'Structure and function of the human body systems.', 'code' => 'BIO250'],
            ['title' => 'Introduction to Computer Science', 'description' => 'Programming fundamentals, algorithms, and problem-solving.', 'code' => 'CS101'],
            ['title' => 'Data Structures', 'description' => 'Arrays, lists, trees, graphs, and algorithm analysis.', 'code' => 'CS201'],
            ['title' => 'Database Management Systems', 'description' => 'SQL, database design, and management principles.', 'code' => 'CS250'],
            ['title' => 'Web Development', 'description' => 'HTML, CSS, JavaScript, and modern web frameworks.', 'code' => 'CS300'],
            ['title' => 'English Literature', 'description' => 'Analysis of classic and contemporary literary works.', 'code' => 'ENG101'],
            ['title' => 'Creative Writing', 'description' => 'Techniques for fiction, poetry, and creative nonfiction.', 'code' => 'ENG150'],
            ['title' => 'World History', 'description' => 'Major historical events and civilizations from ancient to modern times.', 'code' => 'HIST101'],
            ['title' => 'Modern European History', 'description' => 'European history from Renaissance to present day.', 'code' => 'HIST201'],
            ['title' => 'Psychology 101', 'description' => 'Introduction to psychological theories and human behavior.', 'code' => 'PSYCH101'],
            ['title' => 'Developmental Psychology', 'description' => 'Human development across the lifespan.', 'code' => 'PSYCH250'],
            ['title' => 'Sociology Basics', 'description' => 'Study of society, social relationships, and institutions.', 'code' => 'SOC101'],
            ['title' => 'Economics Principles', 'description' => 'Microeconomics and macroeconomics fundamentals.', 'code' => 'ECON101'],
            ['title' => 'Financial Accounting', 'description' => 'Recording, analyzing, and reporting financial transactions.', 'code' => 'ACCT101'],
            ['title' => 'Business Management', 'description' => 'Principles of planning, organizing, and leading organizations.', 'code' => 'BUS200'],
            ['title' => 'Marketing Fundamentals', 'description' => 'Marketing strategies, consumer behavior, and market research.', 'code' => 'MKT101'],
            ['title' => 'Introduction to Philosophy', 'description' => 'Critical thinking, ethics, and major philosophical traditions.', 'code' => 'PHIL101'],
            ['title' => 'Art History', 'description' => 'Survey of visual arts from prehistoric to contemporary periods.', 'code' => 'ART101'],
            ['title' => 'Music Theory', 'description' => 'Fundamentals of music notation, harmony, and composition.', 'code' => 'MUS101'],
            ['title' => 'Spanish I', 'description' => 'Beginner Spanish language and culture.', 'code' => 'SPAN101'],
            ['title' => 'French I', 'description' => 'Beginner French language and culture.', 'code' => 'FREN101'],
            ['title' => 'German I', 'description' => 'Beginner German language and culture.', 'code' => 'GERM101'],
            ['title' => 'Environmental Science', 'description' => 'Study of ecosystems, conservation, and sustainability.', 'code' => 'ENV101'],
            ['title' => 'Statistics', 'description' => 'Data analysis, probability, and statistical inference.', 'code' => 'STAT101'],
            ['title' => 'Political Science', 'description' => 'Government systems, political theory, and public policy.', 'code' => 'POLI101'],
            ['title' => 'Anthropology', 'description' => 'Study of human cultures, evolution, and diversity.', 'code' => 'ANTH101'],
            ['title' => 'Public Speaking', 'description' => 'Techniques for effective oral communication and presentations.', 'code' => 'COMM150'],
            ['title' => 'Graphic Design', 'description' => 'Principles of visual design and digital media creation.', 'code' => 'DES200'],
            ['title' => 'Nutrition and Wellness', 'description' => 'Healthy eating, dietary guidelines, and lifestyle choices.', 'code' => 'HLTH101'],
            ['title' => 'Physical Education', 'description' => 'Fitness, sports, and physical wellness activities.', 'code' => 'PE101'],
            ['title' => 'Introduction to Law', 'description' => 'Legal systems, contracts, and constitutional principles.', 'code' => 'LAW101'],
            ['title' => 'Ethics in Technology', 'description' => 'Moral and ethical issues in computing and technology.', 'code' => 'TECH250'],
        ];
        $course = fake()->randomElement($courses);

        return [
            'title' => $course['title'],
            'code' => $course['code'],
            'description' => $course['description'],
            'hours' => fake()->numberBetween(2, 80) / 2,
        ];
    }
}
