import React, { useState, useEffect } from "react";
import * as NavigationUtils from "../../../helpers/Navigation";
import { Master as MasterLayout } from "../layouts";
import { DragDropContext, Droppable, Draggable } from "react-beautiful-dnd";
import Modal from "react-modal";
import axios from "axios";
import Pusher from "pusher-js";

Modal.setAppElement("#root");

// Pusher Bağlantısını Başlat
const pusher = new Pusher("eb50313860f0fc342360", {
    cluster: "eu",
    encrypted: true
});

function List(props) {
    const [loading, setLoading] = useState(false);
    const [tasks, setTasks] = useState({ pending: [], in_progress: [], completed: [] });
    const [modalIsOpen, setModalIsOpen] = useState(false);
    const [currentTask, setCurrentTask] = useState({ title: "", description: "", status: "pending", start_time: "" });

    useEffect(() => {
        axios.get("/api/v1/kanban-data")
            .then(response => setTasks(response.data))
            .catch(error => console.error("Görevler yüklenemedi:", error));
    }, []);

    useEffect(() => {
        // Kanalı dinleme
        const channel = pusher.subscribe("TaskUpdated");

        channel.bind("task-updated", (data) => {
            console.log("Task Güncellendi:", data);
            setTasks((prevTasks) => {
                const updatedTasks = { ...prevTasks };
                Object.keys(updatedTasks).forEach((key) => {
                    updatedTasks[key] = updatedTasks[key].filter(task => task.id !== data.id);
                });
                updatedTasks[data.status].push(data);
                return updatedTasks;
            });
        });

        return () => {
            channel.unbind_all();
            pusher.unsubscribe("TaskUpdated");
        };
    }, []);

    const handleDragEnd = (result) => {
        if (!result.destination) return;

        const { source, destination } = result;
        const movedTask = tasks[source.droppableId][source.index];

        const newSourceColumn = Array.from(tasks[source.droppableId]);
        const newDestinationColumn = Array.from(tasks[destination.droppableId]);

        newSourceColumn.splice(source.index, 1);
        newDestinationColumn.splice(destination.index, 0, movedTask);

        const newTasks = {
            ...tasks,
            [source.droppableId]: newSourceColumn,
            [destination.droppableId]: newDestinationColumn
        };

        setTasks(newTasks);

        axios.put(`/api/v1/tasks/${movedTask.id}`, { status: destination.droppableId })
            .catch(error => console.error("Görev güncellenemedi:", error));
    };

    const openModal = (task = { title: "", description: "", status: "pending" }) => {
        setCurrentTask(task);
        setModalIsOpen(true);
    };

    const closeModal = () => {
        setModalIsOpen(false);
    };

    const handleSave = () => {
        if (currentTask.id) {
            axios.put(`/api/v1/tasks/${currentTask.id}`, currentTask)
                .then(() => {
                    setTasks(prev => ({
                        ...prev,
                        [currentTask.status]: prev[currentTask.status].map(t =>
                            t.id === currentTask.id ? currentTask : t
                        )
                    }));
                    closeModal();
                });
        } else {
            axios.post("/api/v1/tasks", currentTask)
                .then(response => {
                    setTasks(prev => ({
                        ...prev,
                        [currentTask.status]: [...prev[currentTask.status], response.data]
                    }));
                    closeModal();
                });
        }
    };

    const handleDelete = (taskId, status) => {
        axios.delete(`/api/v1/tasks/${taskId}`)
            .then(() => {
                setTasks(prev => ({
                    ...prev,
                    [status]: prev[status].filter(task => task.id !== taskId)
                }));
            });
    };

    const primaryAction = {
        text: Lang.get('resources.create', {
            name: 'Task',
        }),
        clicked: () =>
            history.push(
                openModal(),
            ),
    };

    const [users, setUsers] = useState([]);

    useEffect(() => {
        axios.get("/api/v1/all-users")
            .then(response => setUsers(response.data))
            .catch(error => console.error("Kullanıcılar yüklenemedi:", error));
    }, []);

    return (
        <MasterLayout
            {...props}
            loading={loading}
            pageTitle={"Görevler"}
            primaryAction={primaryAction}
        >
            {!loading && (
                <>
                    <DragDropContext onDragEnd={handleDragEnd}>
                        <div className="kanban-board">
                            {Object.keys(tasks).map(column => (
                                <Droppable droppableId={column} key={column}>
                                    {(provided) => (
                                        <div ref={provided.innerRef} {...provided.droppableProps} className="kanban-column">
                                            <h3>{column.toUpperCase()}</h3>
                                            {tasks[column].map((task, index) => (
                                                <Draggable key={task.id} draggableId={task.id.toString()} index={index}>
                                                    {(provided) => (
                                                        <div ref={provided.innerRef} {...provided.draggableProps} {...provided.dragHandleProps} className="kanban-task">
                                                            <h4>{task.title}</h4>
                                                            <div className="button-grp">
                                                                <button className="update-btn" onClick={() => openModal(task)}>Düzenle</button>
                                                                <button className="delete-btn" onClick={() => handleDelete(task.id, column)}>Sil</button>
                                                            </div>
                                                        </div>
                                                    )}
                                                </Draggable>
                                            ))}
                                            {provided.placeholder}
                                        </div>
                                    )}
                                </Droppable>
                            ))}
                        </div>
                    </DragDropContext>

                    <Modal isOpen={modalIsOpen} onRequestClose={closeModal} className="modal">
                        <h2>{currentTask.id ? "Görevi Düzenle" : "Yeni Görev Ekle"}</h2>
                        <input className="form-control" type="text" placeholder="Başlık" value={currentTask.title} onChange={(e) => setCurrentTask({ ...currentTask, title: e.target.value })} />
                        <textarea placeholder="Açıklama" value={currentTask.description} onChange={(e) => setCurrentTask({ ...currentTask, description: e.target.value })}></textarea>
                        <input type="datetime-local" value={currentTask.start_time} onChange={(e) => setCurrentTask({ ...currentTask, start_time: e.target.value })}/>
                        <select
                            value={currentTask.user_id || ""}
                            onChange={(e) => setCurrentTask({ ...currentTask, user_id: e.target.value })}
                        >
                            <option value="">Kullanıcı Seç</option>
                            {users.map(user => (
                                <option key={user.id} value={user.id}>{user.name}</option>
                            ))}
                        </select>

                        <button onClick={handleSave}>Kaydet</button>
                        <button onClick={closeModal}>İptal</button>
                    </Modal>
                </>
            )}
        </MasterLayout>
    );
}

export default List;
