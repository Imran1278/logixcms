<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class StudentChatbotController extends Controller
{
    /**
     * LOGIX College AI Assistant
     * Powered by Groq
     */
    public function chat(Request $request): JsonResponse
    {
        // Validate user message
        $request->validate([
            'message' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        $userMessage = trim($request->input('message'));

        // Get Groq configuration from config/services.php
        $apiKey = config('services.groq.key');
        $model  = config('services.groq.model', 'openai/gpt-oss-120b');

        // Check API key
        if (empty($apiKey)) {
            Log::error('Groq API key is missing.');

            return response()->json([
                'status' => 'error',
                'reply'  => 'AI service configuration mein problem hai. Please thori dair baad dobara try karein.',
            ], 200);
        }

        // Check model
        if (empty($model)) {
            Log::error('Groq model is missing.');

            return response()->json([
                'status' => 'error',
                'reply'  => 'AI model configuration mein problem hai. Please administrator se contact karein.',
            ], 200);
        }

        /**
         * AI System Instructions
         */
        $systemKnowledge = <<<PROMPT
You are "EduBot", the official AI Student Assistant for LOGIX College.

Your job is to help students with LOGIX College related questions.

LANGUAGE RULES:
1. Always reply in the same language and style used by the student.
2. If the student writes Roman Urdu, reply in Roman Urdu.
3. If the student writes Urdu script, reply in Urdu script.
4. If the student writes English, reply in English.
5. You can understand mixed Roman Urdu + English.
6. Do not unnecessarily switch languages.

RESPONSE RULES:
1. Answer the student's actual question directly.
2. Keep answers concise, clear, friendly and professional.
3. Do not give unnecessarily long answers.
4. Use simple language that students can easily understand.
5. If useful, use short bullet points.
6. Do not repeat the student's question unnecessarily.
7. Never mention that you are using Groq or any AI model.

LOGIX COLLEGE RULES:
1. Help with admissions, courses, classes, timings, fees, campus information and general student support.
2. Never invent LOGIX College information.
3. Never make up course fees, admission dates, class timings, contact numbers, addresses or policies.
4. If specific LOGIX information is not available in the provided knowledge, clearly tell the student that the information should be confirmed with LOGIX College administration.
5. Do not present guesses as official information.

CONVERSATION STYLE:
- Be polite and helpful.
- If the student says "Assalam o Alaikum", respond naturally.
- If the student says "hi", "hello", or "aoa", greet them naturally.
- If the student asks a simple question, give a simple answer.
- If the student asks multiple questions, answer each one clearly.
- Never be rude or argumentative.

IDENTITY:
You are "EduBot", the LOGIX College Student Assistant.
PROMPT;

        try {

            $endpoint = 'https://api.groq.com/openai/v1/chat/completions';

            /**
             * Send request to Groq
             */
            $response = Http::timeout(30)
                ->connectTimeout(10)
                ->withToken($apiKey)
                ->acceptJson()
                ->post($endpoint, [
                    'model' => $model,

                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $systemKnowledge,
                        ],
                        [
                            'role' => 'user',
                            'content' => $userMessage,
                        ],
                    ],

                    'temperature' => 0.7,

                    'max_completion_tokens' => 500,
                ]);

            /**
             * Successful response
             */
            if ($response->successful()) {

                $responseData = $response->json();

                $reply = data_get(
                    $responseData,
                    'choices.0.message.content'
                );

                if (!empty($reply)) {

                    return response()->json([
                        'status' => 'success',
                        'reply'  => trim($reply),
                    ]);
                }

                // Unexpected response format
                Log::error('Groq returned an empty or invalid response.', [
                    'status' => $response->status(),
                    'model'  => $model,
                ]);

                return response()->json([
                    'status' => 'error',
                    'reply'  => 'AI ne koi valid response nahi diya. Please dobara try karein.',
                ], 200);
            }

            /**
             * Groq API Error
             */
            $errorData = $response->json();

            $apiError = data_get(
                $errorData,
                'error.message',
                'Unknown Groq API error.'
            );

            $errorCode = data_get(
                $errorData,
                'error.code'
            );

            Log::error('Groq API request failed.', [
                'http_status' => $response->status(),
                'error_code'  => $errorCode,
                'error'       => $apiError,
                'model'       => $model,
            ]);

            /**
             * User-friendly error messages
             */

            // Invalid / unauthorized API key
            if ($response->status() === 401) {

                return response()->json([
                    'status' => 'error',
                    'reply'  => 'AI service authentication problem hai. Please administrator se contact karein.',
                ], 200);
            }

            // Permission / access problem
            if ($response->status() === 403) {

                return response()->json([
                    'status' => 'error',
                    'reply'  => 'AI service access temporarily unavailable hai. Please baad mein dobara try karein.',
                ], 200);
            }

            // Rate limit
            if ($response->status() === 429) {

                return response()->json([
                    'status' => 'error',
                    'reply'  => 'AI service par abhi zyada requests hain. Please thori dair baad dobara try karein.',
                ], 200);
            }

            // Model not found
            if (
                $response->status() === 404 ||
                $errorCode === 'model_not_found'
            ) {

                return response()->json([
                    'status' => 'error',
                    'reply'  => 'AI model temporarily unavailable hai. Please administrator se contact karein.',
                ], 200);
            }

            // Other API errors
            return response()->json([
                'status' => 'error',
                'reply'  => 'AI service se response nahi mil saka. Please dobara try karein.',
            ], 200);

        } catch (Throwable $e) {

            /**
             * Log technical error.
             * Never expose technical details to students.
             */
            Log::error('Student Chatbot Exception.', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return response()->json([
                'status' => 'error',
                'reply'  => 'AI service se connection nahi ho saka. Please dobara try karein.',
            ], 200);
        }
    }
}