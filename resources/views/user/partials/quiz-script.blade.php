@extends('')

<script>
        (function () {
            // Konfigurasi dasar
            const TUTORIAL_ID = 1; // ganti sesuai tutorial nyata nanti
            const LS_KEY = `quiz_progress_tutorial_${TUTORIAL_ID}`;
            const PASSING_PERCENT = 60; // threshold lulus

            // Dummy soal (MCQ)
            const quizData = {
                title: 'Uji Pemahaman - Pengenalan Blender',
                passing: PASSING_PERCENT,
                questions: [
                    {
                        id: 1,
                        type: 'mcq',
                        question: 'Apa shortcut untuk mengganti mode Edit/Object di Blender?',
                        choices: ['G', 'R', 'Tab', 'S'],
                        answerIndex: 2,
                        explanation: 'Tekan Tab untuk berpindah antara Object Mode dan Edit Mode.'
                    },
                    {
                        id: 2,
                        type: 'mcq',
                        question: 'Tool mana yang biasa dipakai untuk mengganti posisi objek?',
                        choices: ['Move (G)', 'Rotate (R)', 'Scale (S)', 'Loop Cut'],
                        answerIndex: 0,
                        explanation: 'Move menggunakan shortcut G.'
                    },
                    {
                        id: 3,
                        type: 'mcq',
                        question: 'Format file Blender default adalah?',
                        choices: ['.blend', '.blend2', '.bld', '.bnk'],
                        answerIndex: 0,
                        explanation: 'File project Blender berekstensi .blend.'
                    },
                    {
                        id: 4,
                        type: 'mcq',
                        question: 'Untuk melakukan render cepat, biasanya kita menekan tombol?',
                        choices: ['F12', 'Ctrl+S', 'Alt+R', 'F5'],
                        answerIndex: 0,
                        explanation: 'F12 digunakan untuk render di Blender.'
                    },
                    {
                        id: 5,
                        type: 'mcq',
                        question: 'Viewport orbit (memutar tampilan) biasa dilakukan dengan?',
                        choices: ['Middle Mouse Button (klik+tahan)', 'Right Click', 'Spacebar', 'Ctrl+C'],
                        answerIndex: 0,
                        explanation: 'Orbit umumnya dengan menahan Middle Mouse Button.'
                    }
                ]
            };

            // Elemen DOM
            const statusBadge = document.getElementById('quizStatusBadge');
            const quizTotal = document.getElementById('quizTotal');
            const quizPassing = document.getElementById('quizPassing');
            const startBtn = document.getElementById('startQuizBtn');
            const resetBtn = document.getElementById('resetQuizBtn');

            const introBox = document.getElementById('quizIntro');
            const quizUI = document.getElementById('quizUI');
            const questionBox = document.getElementById('questionBox');
            const questionCounter = document.getElementById('questionCounter');
            const scoreCounter = document.getElementById('scoreCounter');
            const progressBar = document.getElementById('quizProgressBar');
            const feedbackBox = document.getElementById('questionFeedback');

            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitBtn');

            const quizResult = document.getElementById('quizResult');
            const finalScoreTitle = document.getElementById('finalScoreTitle');
            const finalScoreText = document.getElementById('finalScoreText');
            const finalRecommendation = document.getElementById('finalRecommendation');
            const retryBtn = document.getElementById('retryBtn');

            // State
            let currentIndex = 0;
            let answers = new Array(quizData.questions.length).fill(null);
            let score = 0;
            let statusObj = loadStatus(); // { state: 'not_started'|'in_progress'|'failed'|'complete', attempts: n, best: x }

            // Init UI values
            quizTotal.textContent = quizData.questions.length;
            quizPassing.textContent = quizData.passing + '%';
            updateStatusBadge();

            // Event handlers
            startBtn.addEventListener('click', () => {
                startQuiz();
            });

            resetBtn.addEventListener('click', () => {
                if (!confirm('Reset progress quiz ini?')) return;
                localStorage.removeItem(LS_KEY);
                statusObj = loadStatus();
                answers = new Array(quizData.questions.length).fill(null);
                score = 0;
                currentIndex = 0;
                hideAll();
                updateStatusBadge();
                alert('Progress quiz telah direset.');
            });

            prevBtn.addEventListener('click', () => {
                if (currentIndex > 0) {
                    currentIndex--;
                    renderQuestion();
                }
            });

            nextBtn.addEventListener('click', () => {
                // jika belum memilih jawaban, beri peringatan
                if (answers[currentIndex] === null) {
                    alert('Pilih jawaban terlebih dahulu sebelum melanjutkan.');
                    return;
                }
                // beri feedback singkat
                showFeedbackFor(currentIndex);

                // move to next atau show submit
                if (currentIndex < quizData.questions.length - 1) {
                    currentIndex++;
                    renderQuestion();
                } else {
                    // last soal -> show submit
                    nextBtn.classList.add('d-none');
                    submitBtn.classList.remove('d-none');
                }
            });

            submitBtn.addEventListener('click', () => {
                if (answers.includes(null)) {
                    if (!confirm('Masih ada soal yang belum dijawab. Submit tetap?')) {
                        return;
                    }
                }
                calculateResult();
            });

            retryBtn.addEventListener('click', () => {
                if (!confirm('Mulai ulang quiz dari awal?')) return;
                answers = new Array(quizData.questions.length).fill(null);
                score = 0;
                currentIndex = 0;
                statusObj.state = 'in_progress';
                saveStatus();
                updateStatusBadge();
                showQuizUI();
                renderQuestion();
            });

            // Functions
            function loadStatus() {
                try {
                    const raw = localStorage.getItem(LS_KEY);
                    if (!raw) return { state: 'not_started', attempts: 0, best: 0 };
                    return JSON.parse(raw);
                } catch (e) {
                    return { state: 'not_started', attempts: 0, best: 0 };
                }
            }

            function saveStatus() {
                localStorage.setItem(LS_KEY, JSON.stringify(statusObj));
                updateStatusBadge();
            }

            function updateStatusBadge() {
                const s = statusObj.state || 'not_started';
                statusBadge.textContent = s;
                statusBadge.className = 'badge me-2';
                if (s === 'not_started') statusBadge.classList.add('bg-secondary');
                else if (s === 'in_progress') statusBadge.classList.add('bg-info');
                else if (s === 'failed') statusBadge.classList.add('bg-danger');
                else if (s === 'complete') statusBadge.classList.add('bg-success');
            }

            function startQuiz() {
                statusObj.state = 'in_progress';
                saveStatus();
                showQuizUI();
                renderQuestion();
            }

            function showQuizUI() {
                introBox.classList.add('d-none');
                quizUI.classList.remove('d-none');
                quizUI.setAttribute('aria-hidden', 'false');
                quizResult.classList.add('d-none');
                quizResult.setAttribute('aria-hidden', 'true');
            }

            function hideAll() {
                introBox.classList.remove('d-none');
                quizUI.classList.add('d-none');
                quizResult.classList.add('d-none');
            }

            function renderQuestion() {
                const q = quizData.questions[currentIndex];
                questionCounter.textContent = `Soal ${currentIndex + 1}/${quizData.questions.length}`;
                scoreCounter.textContent = `Skor: ${score}`;
                const pct = Math.round(((currentIndex) / quizData.questions.length) * 100);
                progressBar.style.width = `${pct}%`;
                progressBar.setAttribute('aria-valuenow', pct);

                // build HTML
                let html = `<div><h6 class="mb-2">${currentIndex + 1}. ${escapeHtml(q.question)}</h6>`;

                if (q.type === 'mcq') {
                    html += `<form id="choiceForm">`;
                    q.choices.forEach((c, idx) => {
                        const checked = answers[currentIndex] === idx ? 'checked' : '';
                        html += `
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="choice" id="choice_${idx}" value="${idx}" ${checked}>
                                <label class="form-check-label" for="choice_${idx}">${escapeHtml(c)}</label>
                            </div>`;
                    });
                    html += `</form>`;
                } else {
                    html += `<input id="shortAnswer" class="form-control" value="${answers[currentIndex] ?? ''}" />`;
                }

                html += `</div>`;

                questionBox.innerHTML = html;
                feedbackBox.innerHTML = ''; // clear feedback

                // set prev/next button states
                prevBtn.disabled = currentIndex === 0;
                nextBtn.classList.remove('d-none');
                submitBtn.classList.add('d-none');

                // if already answered, show feedback
                if (answers[currentIndex] !== null) {
                    showFeedbackFor(currentIndex);
                    // if last question and all answered, show submit
                    if (currentIndex === quizData.questions.length - 1 && !answers.includes(null)) {
                        nextBtn.classList.add('d-none');
                        submitBtn.classList.remove('d-none');
                    }
                }

                // attach change listener
                const form = document.getElementById('choiceForm');
                if (form) {
                    form.addEventListener('change', (e) => {
                        const v = form.elements['choice'].value;
                        answers[currentIndex] = Number(v);
                        // enable next
                    });
                } else {
                    const short = document.getElementById('shortAnswer');
                    if (short) {
                        short.addEventListener('input', (e) => {
                            answers[currentIndex] = e.target.value.trim();
                        });
                    }
                }
            }

            function showFeedbackFor(index) {
                const q = quizData.questions[index];
                let fbHtml = '';
                const userAns = answers[index];

                if (q.type === 'mcq') {
                    if (userAns === q.answerIndex) {
                        fbHtml = `<div class="alert alert-success py-2">Benar. <small class="text-muted">${escapeHtml(q.explanation)}</small></div>`;
                    } else {
                        fbHtml = `<div class="alert alert-danger py-2">Salah. <small class="text-muted">${escapeHtml(q.explanation)}</small></div>`;
                    }
                } else {
                    // short answer: compare lowercase
                    if (typeof userAns === 'string' && userAns.toLowerCase() === String(q.answer).toLowerCase()) {
                        fbHtml = `<div class="alert alert-success py-2">Benar. <small class="text-muted">${escapeHtml(q.explanation || '')}</small></div>`;
                    } else {
                        fbHtml = `<div class="alert alert-danger py-2">Salah. <small class="text-muted">${escapeHtml(q.explanation || '')}</small></div>`;
                    }
                }

                feedbackBox.innerHTML = fbHtml;
            }

            function calculateResult() {
                // calculate score
                score = 0;
                quizData.questions.forEach((q, idx) => {
                    if (q.type === 'mcq') {
                        if (answers[idx] === q.answerIndex) score++;
                    } else {
                        if (String(answers[idx]).toLowerCase() === String(q.answer).toLowerCase()) score++;
                    }
                });

                const total = quizData.questions.length;
                const percent = Math.round((score / total) * 100);
                finalScoreTitle.textContent = `${score} / ${total} benar`;
                finalScoreText.textContent = `Skor: ${percent}%`;
                if (percent >= quizData.passing) {
                    finalRecommendation.innerHTML = `<div class="alert alert-success">Selamat! Kamu lulus kuis ini.</div>`;
                    statusObj.state = 'complete';
                } else {
                    finalRecommendation.innerHTML = `<div class="alert alert-warning">Skor belum mencapai passing. Pelajari kembali materi lalu coba lagi.</div>`;
                    statusObj.state = 'failed';
                }

                // update attempts and best
                statusObj.attempts = (statusObj.attempts || 0) + 1;
                statusObj.best = Math.max(statusObj.best || 0, percent);
                saveStatus();

                // show result
                showResultUI(percent);
            }

            function showResultUI(percent) {
                quizUI.classList.add('d-none');
                quizResult.classList.remove('d-none');
                quizResult.setAttribute('aria-hidden', 'false');
                introBox.classList.add('d-none');
                // set progress bar to 100%
                progressBar.style.width = '100%';
                progressBar.setAttribute('aria-valuenow', 100);
                finalScoreTitle.focus?.();
            }

            // escape helper
            function escapeHtml(unsafe) {
                return String(unsafe)
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            // on load: if status already in_progress or complete, show hint
            (function init() {
                if (statusObj.state === 'in_progress') {
                    // allow resume
                    const resume = confirm('Kamu memiliki attempt quiz yang sedang berlangsung. Lanjutkan? (OK untuk lanjut, Cancel untuk reset)');
                    if (resume) {
                        showQuizUI();
                        renderQuestion();
                    } else {
                        localStorage.removeItem(LS_KEY);
                        statusObj = loadStatus();
                        updateStatusBadge();
                    }
                } else if (statusObj.state === 'complete') {
                    // show summary quick
                    document.getElementById('quizIntro').innerHTML += `<div class="mt-2"><small class="text-success">Status: sudah lulus — skor terbaik: ${statusObj.best}% (${statusObj.attempts} attempts)</small></div>`;
                } else if (statusObj.state === 'failed') {
                    document.getElementById('quizIntro').innerHTML += `<div class="mt-2"><small class="text-warning">Status: gagal — skor terbaik: ${statusObj.best}% (${statusObj.attempts} attempts)</small></div>`;
                }
            })();

        })();