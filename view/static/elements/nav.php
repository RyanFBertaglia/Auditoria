<div class="botoes-fixos">
    <a href="/">Página Inicial</a>
    <a href="/posts">Postagens</a>
    <a href="/reclamar">Postar</a>
</div>

<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .botoes-fixos {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #4a6fa5;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 16px 24px;
            display: flex;
            justify-content: center;
            gap: 48px;
            z-index: 999;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .botoes-fixos a {
            color: white;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.2s ease;
            position: relative;
        }

        .botoes-fixos a::before {
            content: '';
            position: absolute;
            bottom: -16px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background-color: #daa21b;
            transition: width 0.3s ease;
        }

        .botoes-fixos a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #daa21b;
        }

        .botoes-fixos a:hover::before {
            width: 100%;
        }

        .botoes-fixos a:active {
            transform: translateY(1px);
        }

        .botoes-fixos a:focus-visible {
            outline: 2px solid #daa21b;
            outline-offset: 2px;
        }

        @media (max-width: 768px) {
            .botoes-fixos {
                padding: 12px 16px;
                gap: 24px;
            }
            
            .botoes-fixos a {
                font-size: 14px;
                padding: 6px 12px;
            }
        }

        @media (max-width: 480px) {
            .botoes-fixos {
                gap: 16px;
                flex-wrap: wrap;
                justify-content: space-around;
            }
        }
    </style>