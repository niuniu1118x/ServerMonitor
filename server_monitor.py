import psutil
import platform
import json
import socket
import time
from datetime import datetime

def get_server_status():
    cpu_usage = psutil.cpu_percent()
    memory_usage = psutil.virtual_memory().percent
    uptime = time.time() - psutil.boot_time()
    online_time = str(datetime.utcfromtimestamp(uptime)).split()[1]
    cpu_model = platform.processor()
    os_info = platform.platform()
    hostname = socket.gethostname()

    # Network traffic information
    net_io = psutil.net_io_counters()
    network_info = {
        "sent": net_io.bytes_sent,
        "received": net_io.bytes_recv
    }

    return {
        "status": "服务器正在运行",
        "cpu_usage": cpu_usage,
        "memory_usage": memory_usage,
        "online_time": online_time,
        "cpu_model": cpu_model,
        "os": os_info,
        "hostname": hostname,
        "network_info": network_info
    }

def start_tcp_server(host, port):
    server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    server_socket.bind((host, port))
    server_socket.listen(1)

    print(f"TCP服务器正在监听 {host}:{port}")

    while True:
        conn, addr = server_socket.accept()
        print(f"已连接 {addr}")

        try:
            status_info = get_server_status()
            conn.sendall(json.dumps(status_info).encode())
        except Exception as e:
            print(f"错误: {str(e)}")

        conn.close()

if __name__ == "__main__":
    HOST = '0.0.0.0'  # 监听所有网络接口
    PORT = 8888  # TCP服务器端口
    start_tcp_server(HOST, PORT)
